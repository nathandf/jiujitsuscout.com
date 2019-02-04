<?php

namespace Controllers\Cron;

use Core\Controller;

class Sequences extends Controller
{
	public function before()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );

		// Only run script if cron_token is present
		if (
			!$input->exists( "get" ) ||
			!$inputValidator->validate(
				$input,
				[ "cron_token" => [ "required" => true ] ],
				null
			)
		) {
			die();
			exit();
		}

		$this->logger = $this->load( "logger" );
		$this->logger->info( "Cron Start: Sequences" );
	}

	public function after()
	{
		$this->logger->info( "Cron End: Seqences" );
		die();
		exit();
	}

	public function indexAction()
	{
		$sequenceManager = $this->load( "sequence-dispatcher" );
        $sequenceManager->dispatch();
	}
}
