<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = User::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition():array
	{
		/*
		$factory->define(App\Models\User::class, function (Faker $faker) {
			return [
				'name' => $faker->name,
				'email' => $faker->unique()->safeEmail,
				'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
				'remember_token' => \Illuminate\Support\Str::random(10),
			];
		});
		*/

		return [
			'name' => $this->faker->name,
			'email' => $this->faker->unique()->safeEmail,
			'email_verified_at' => now(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'remember_token' => Str::random(10),
		];
	}
}