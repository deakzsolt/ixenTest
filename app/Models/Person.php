<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * This will return address
     *
     * @return HasOne
     */
    public function personAdres(): HasOne
    {
        return $this->hasOne(PersonAdres::class);
    }

    /**
     * This will return all contacts like email, phone, etc.
     *
     * @return HasMany
     */
    public function PersonContacts(): HasMany
    {
        return $this->hasMany(PersonContacts::class);
    }
}
