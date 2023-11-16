<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /** @var Person */
    private Person $person;

    /** @var PersonService */
    private PersonService $personService;

    /**
     * @param Person $person
     */
    public function __construct(Person $person, PersonService $personService)
    {
        $this->person = $person;
        $this->personService = $personService;
    }

    /**
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json($this->personService->list());
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'         => 'required|min:2|max:255',
            'last_name'          => 'required|min:2|max:255',
            'permanent_address'  => 'required|min:5|max:255',
            'temporary_address'  => 'nullable|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 200);
        } // if

        return response()->json($this->personService->store($request));
    }

    /**
     * @param Person $person
     *
     * @return JsonResponse
     */
    public function edit(Person $person)
    {
        return response()->json($this->personService->getPerson($person));
    }

    /**
     * @param Request $request
     * @param Person  $person
     *
     * @return JsonResponse
     */
    public function update(Request $request, Person $person)
    {
        $validator = Validator::make($request->all(), [
            'first_name'         => 'required|min:2|max:255',
            'last_name'          => 'required|min:2|max:255',
            'permanent_address'  => 'required|min:5|max:255',
            'temporary_address'  => 'nullable|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 200);
        } // if

        return response()->json($this->personService->updatePerson($request, $person));
    }

    /**
     * @param Person $person
     *
     * @return JsonResponse
     */
    public function destroy(Person $person)
    {
        if ($person->delete()) {
            return Response::json(
                [
                    'success' => true,
                ]
            );
        } // if

        return Response::json(
            [
                'success' => false,
            ]
        );
    }
}
