<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'persons';
	
	/**
	 * The database table used by the model.
	 *
	 * @var array
	 */
	protected $appends = ['name_initials'];

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'username', 
		'email', 
		'street',
		'suite',
		'city',
		'zipcode',
		'geo_lat',
		'geo_lng',
		'website',
		'company_name',
		'company_catch_phrase',
		'company_bs'
	];

	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = [
		'id',
		'name',
		'username', 
		'email',
		'name_initials'
	];

	/**
	 * Get initials.
	 *
	 * @return string
	 */
	public function getNameInitialsAttribute()
	{
		return $this->name[0];
	}

	/**
     * Get the albums of person.
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
