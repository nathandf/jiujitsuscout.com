<?php

namespace Controllers\Partner;

use \Core\Controller;

class Features extends Controller
{

	public function indexAction()
	{
		echo "All features";
	}

	public function leadCaptureProfileAction()
	{
		echo "Lead Capture Profile Feature";
	}

	public function leadGenerationAction()
	{
		echo "Lead Generation Feature";
	}

	public function emailMarketingAction()
	{
		echo "Email Marketing Feature";
	}

	public function landingPageBuilder()
	{
		echo "Landing Page Builder";
	}

}
