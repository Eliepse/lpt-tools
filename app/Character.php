<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $character
 * @property string|null $definition
 * @property array $pinyin
 * @property string $decomposition
 * @property array $etymology
 * @property string $radical
 * @property array $matches
 */
class Character extends Model
{
	protected $table = 'dictionary';

	protected $guarded = [];

	public $timestamps = false;

	protected $casts = [
		'pinyin'    => 'array',
		'etymology' => 'array',
		'matches'   => 'array',
	];
}
