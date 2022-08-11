<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Album extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'albums';

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'person_id',
		'title',
    ];

	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = [
		'id',
        'title',
        'photo_count'
    ];

    protected $appends = ['photo_count'];

    /**
     * Get the photos of album.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get the photo count of album.
     */
    public function getPhotoCountAttribute()
    {
        return $this->hasMany('App\Models\Photo')->where("album_id", $this->id)->count();
    }
}
