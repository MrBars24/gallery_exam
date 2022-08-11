<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'photos';

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'album_id',
		'title',
        'url',
        'thumbnail_url'
    ];

    protected $appends = ['photos_count'];

	/**
	 * The attributes that should be visible in arrays.
	 *
	 * @var array
	 */
	protected $visible = [
		'id',
		'title',
        'url',
        'thumbnail_url'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
