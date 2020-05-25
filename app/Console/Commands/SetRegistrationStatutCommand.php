<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SetRegistrationStatutCommand extends Command
{

	protected $signature = 'registration:statut {action} {type}';

	protected $description = 'Get or set the statut of a registration service';


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
	 * @return mixed
	 */
	public function handle()
	{
		$action = $this->argument("action");
		$type = $this->argument("type");
		if (! in_array($action, ["open", "close", "show"])) {
			$this->error("Incorrect action");
			return;
		}

		switch ($action) {
			case "open":
				Cache::forever("registration.statut:$type", true);
				$this->info("Registration '$type' has been opened.");
				break;
			case "close":
				Cache::forever("registration.statut:$type", false);
				$this->info("Registration '$type' has been closed.");
				break;
			case "show":
				if (! Cache::has("registration.statut:$type")) {
					$this->info("Registration '$type' is not set (but considered as closed).");
					break;
				}
				$statut = Cache::get("registration.statut:$type") ? "open" : "close";
				$this->info("Registration '$type' is $statut.");
				break;
		}
	}
}
