<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new user';


	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle(): int
	{
		$user = new User();

		do {
			$user->name = $this->ask("Nom d'utilisateur ?");
		} while (empty($user->name));

		do {
			$user->email = $this->ask("Email ?");
		} while (Validator::make(["a" => $user->email], ["a" => "email"])->fails());

		do {
			$password = $this->secret("Mot de passe ?");
		} while (Validator::make(["a" => $password], ["a" => "min:4"])->fails());

		$user->password = Hash::make($password);
		$user->save();

		return 0;
	}
}
