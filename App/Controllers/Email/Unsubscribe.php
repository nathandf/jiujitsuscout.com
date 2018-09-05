<?php

namespace Controllers\Email;

use \Core\Controller;

class Unsubscribe extends Controller
{

	public function indexAction()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$unsubscribeRepo = $this->load( "unsubscribe-repository" );

		$emails = $unsubscribeRepo->getAllEmails();

		if ( $input->exists( "get" ) && $input->issetField( "email" ) && $inputValidator->validate(
				$input,
				[
					"email" => [
						"required" => true,
						"email" => true
					]
				],
				"unsubscribe"
			) )
		{
			$this->view->assign( "email", $input->get( "email" ) );
		}

		$this->view->setTemplate( "email/unsubscribe/home.tpl" );

		if ( in_array( $input->get( "email" ), $emails ) ) {
			$this->view->setTemplate( "email/unsubscribe/unsubscribed.tpl" );
		}

		$this->view->render( "App/Views/Email/Unsubscribe.php" );
	}

	public function confirm()
	{
		$input = $this->load( "input" );
		$inputValidator = $this->load( "input-validator" );
		$unsubscribeRepo = $this->load( "unsubscribe-repository" );

		if ( $input->exists() && $input->issetField( "email" ) && $inputValidator->validate(
				$input,
				[
					"email" => [
						"required" => true,
						"email" => true
					]
				],
				"unsubscribe"
			) )
		{
			$unsubscribeRepo->create( $input->get( "email" ) );

			$this->view->setTemplate( "email/unsubscribe/unsubscribed.tpl" );
			$this->view->render( "App/Views/Email/Unsubscribe.php" );

			return true;
		}

		$this->view->redirect( "email/unsubscribe/error" );
		return false;
	}

	public function error()
	{
		$this->view->setTemplate( "email/unsubscribe/error.tpl" );
		$this->view->render( "App/Views/Email/Unsubscribe.php" );
	}
}
