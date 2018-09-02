<?php

namespace Controllers;

use \Core\Controller;

class Tracking extends Controller
{
    public function recordClick()
	{
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $businessRepo = $this->load( "business-repository" );
        $clickRepo = $this->load( "click-repository" );

        $businesses = $businessRepo->getAll();
        $business_ids = [];

        foreach ( $businesses as $business ) {
            $business_ids[] = $business->id;
        }

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "business_id" => [
                    "required" => true,
                    "in_array" => $business_ids
                ],
                "ip" => [
                    "required" => true,
                ],
                "property" => [
                    "required" => true,
                ]
            ],
            "click"
            ) )
        {
            $clickRepo->create(
                $input->get( "business_id" ),
                $input->get( "ip" ),
                $input->get( "property" ),
                time()
            );

            return true;
        }

        return false;
	}
}
