<?php

namespace App\Services;

use App\Models\Person;
use App\Models\PersonAddress;
use App\Models\PersonContacts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PersonService
{
    /** @var Person */
    private Person $person;

    /**
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->person->orderBy('id', 'desc')->with('PersonContacts', 'PersonAddress')->get();
    }

    /**
     * @param Person $person
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getPerson(Person $person)
    {
        return $this->person->with('PersonContacts', 'PersonAddress')->find($person->id);
    }

    public function store(Request $request)
    {
        $personData = $request->all();
        $this->person->fill($personData);
        $this->person->save();

        if (isset($personData['permanent_address'])) {
            $personAddress = new PersonAddress();
            $personAddress->person_id = $this->person->id;
            $personAddress->permanent_address = $personData['permanent_address'];
            $personAddress->temporary_address = isset($personData['temporary_address']) ? $personData['temporary_address'] : '';
            $personAddress->save();
        } // if

        if (isset($personData['person_contacts'])) {
            foreach ($personData['person_contacts'] as $contact) {
                $personContact = new PersonContacts();
                $personContact->person_id = $this->person->id;
                $personContact->contact_type = $contact['contact_type'];
                $personContact->contact_value = $contact['contact_value'];
                $personContact->save();
            } // foreach
        } // if

        return $this->person->with('PersonContacts', 'PersonAddress')->find($this->person->id);
    }

    /**
     * @param Request $request
     * @param Person  $person
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function updatePerson(Request $request, Person $person)
    {

        $personData = $request->all();
        $person->first_name = isset($personData['first_name']) ? $personData['first_name'] : $person->first_name;
        $person->last_name = isset($personData['last_name']) ? $personData['last_name'] : $person->last_name;
        $person->save();

        if (isset($personData['permanent_address'])) {
            $personAddress = $person->personAddress;
            $personAddress->permanent_address = $personData['permanent_address'];
            $personAddress->temporary_address = isset($personData['temporary_address']) ? $personData['temporary_address'] : $person->temporary_address;
            $personAddress->update();
        } // if

        if (isset($personData['person_contacts'])) {
            foreach ($personData['person_contacts'] as $contact) {
                $personContact = new PersonContacts();
                $personContact->person_id = $this->person->id;
                $personContact->contact_type = $contact['contact_type'];
                $personContact->contact_value = $contact['contact_value'];
                $personContact->save();
            } // foreach
        } // if

        return $this->person->with('PersonContacts', 'PersonAddress')->find($person->id);
    }
}
