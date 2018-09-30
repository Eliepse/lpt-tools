<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $character
 * @property array $strokes
 * @property array $medians
 *
 */
class Graphic extends Model
{
	protected $table = 'graphics';

	protected $guarded = [];

	public $timestamps = false;

	protected $casts = [
		'strokes' => 'array',
		'medians' => 'array',
	];

}
