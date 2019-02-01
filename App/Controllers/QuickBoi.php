<?php

namespace Controllers;

use \Core\Controller;

class QuickBoi extends Controller
{
    public function indexAction()
	{
		$db = $this->load( "dao" );
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$quickBoi = $this->load( "quick-boi" );

		$quickBoi->setApplicationNamespace( "App" )
			->setEntityNamespace( "Model" )
			->setRepositoryNamespace( "Model\Services" )
			->setMapperNamespace( "Model\Mappers" );

		$quickBoi->buildModel( "lead-capture" );
	}
}
