<?php

namespace Controllers;

use \Core\Controller;

class Form extends Controller
{
    public function before()
    {
        $this->requireParam( "token" );
    }

    public function newProspectAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $businessRepo = $this->load( "business-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $countryRepo = $this->load( "country-repository" );
        $prospectRegistrar = $this->load( "prospect-registrar" );
        $prospectRepo = $this->load( "prospect-repository" );
        $noteRegistrar = $this->load( "note-registrar" );
        $userMailer = $this->load( "user-mailer" );
        $request = $this->load( "request" );
        $userRepo = $this->load( "user-repository" );
        $leadCaptureBuilder = $this->load( "lead-capture-builder" );
        $config = $this->load( "config" );

        $embeddableForm = $embeddableFormRepo->getByToken( $this->params[ "token" ] );

        if ( is_null( $embeddableForm->id ) ) {
            $this->view->render404();
        }

        // Source means where the prospect came from
        $source = "Embeddable Form: " . $embeddableForm->name;

        // Get the business that owns this form
        $business = $businessRepo->get( [ "*" ], [ "id" => $embeddableForm->business_id ], "single");

        // Get phone for business
        $business->phone = $phoneRepo->get( [ "*" ], [ "id" => $business->phone_id ], "single" );

        // Get all elements of this embeddable form and assign respective embeddable form
        // element type object.
        $embeddableFormElements = $embeddableFormElementRepo->getAllByEmbeddableFormID( $embeddableForm->id );

        $submittableFields = [];
        foreach ( $embeddableFormElements as $embeddableFormElement ) {
            $embeddableFormElement->type = $embeddableFormElementTypeRepo->getByID(
                $embeddableFormElement->embeddable_form_element_type_id
            );

            // Create an array of all possible submittable fields based on elements
            // of this form. The keys of this array will be formatted and map directly
            // to properties of the prospect being registered or related objects
            $index = preg_replace( "/[\s]+/", "_", trim( strtolower( $embeddableFormElement->type->name ) ) );
            $prospectInfo[ "$index" ] = null;
        }

        // Add this business's website to the origin whitelist for CORs
        $origins = $config::$configs[ "allowable_origins" ];
        array_push( $origins, $business->website );
        $request->populateWhitelist( $origins );

        // Check that the origin of this request is on the whitelist and set the access
        // control cross origin header through the request object.
        if ( !$request->allowOrigin( $request->getOrigin() ) ) {
            $this->view->render403();
        }

        // Validate request. Token submitted by the form must be equal to the
        // token in the url. "f873f916d9706847402b08cd30c5d584" is the md5 hash
        // of "this is a mother fuckin honey pot". This should obviously be empty.
        // If not, this was submitted by a bot
        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->params[ "token" ],
                    "required" => true
                ],
                "f873f916d9706847402b08cd30c5d584" => [
                    "required-empty" => true
                ]
            ],
            "form_submission"
            )
        ) {
            $hasMessage = false;
            $hasEmail = false;
            $hasPhone = false;

            // Handle submitted fields to create propectProperties
            foreach ( $prospectInfo as $key => $element ) {
                switch ( $key ) {
                    case "phone_number":
                        $country = $countryRepo->get( [ "*" ], [ "iso" => $business->country ], "single" );
                        $phone = $phoneRepo->create( $country->phonecode, $input->get( $key ) );
                        $prospectInfo[ "phone_id" ] = $phone->id;
                        $hasPhone = true;

                        break;

                    case "name":
                        $name = $input->get( $key );
                        $full_name = explode( " ", $name, 2 );
                        $prospectInfo[ "first_name" ] = null;
                        $prospectInfo[ "last_name" ] = null;

                        if ( count( $full_name ) > 1 ) {
                            $prospectInfo[ "last_name" ] = $full_name[ 1 ];
                        }
                        $prospectInfo[ "first_name" ] = $full_name[ 0 ];

                        break;

                    case "message":
                        $hasMessage = true;
                        $prospectInfo[ $key ] = $input->get( $key );

                        break;

                    default:
                        $prospectInfo[ $key ] = $input->get( $key );

                        break;
                }
            }

            $prospectInfo[ "business_id" ] = $business->id;
            $prospectInfo[ "source" ]  = $source;

            $requiredProspectProperties = [
                "first_name",
                "last_name",
                "email",
                "phone_id",
                "business_id",
                "source"
            ];

            foreach ( $requiredProspectProperties as $property ) {
                $prospectInfo[ $property ] = ( isset( $prospectInfo[ $property ] ) != false ) ? $prospectInfo[ $property ] : null;
            }

            // Create prospect
            $prospectRegistrar->add( $prospectInfo );

            // Get new prospect
            $prospect = $prospectRegistrar->getProspect();

            // Record lead capture
            $leadCaptureBuilder->setProspectID( $prospect->id )
                ->setEmbeddableFormID( $embeddableForm->id )
                ->build();

            // Assign phone to prospect
            $prospect->phone = $phoneRepo->getByID( $prospect->phone_id );

            $user_notification_recipient_ids = explode( ",", $business->user_notification_recipient_ids );

            // Send users lead capture notifications
            foreach ( $user_notification_recipient_ids as $id ) {
                $user = $userRepo->getByID( $id );
                $userMailer->sendLeadCaptureNotification(
                    $user->first_name,
                    $user->email,
                    $additional_info = [
                        "id" => $prospect->id,
                        "name" => $prospect->getFullName(),
                        "email" => $email = !is_null( $prospect->email) ? $prospect->email : "N/a",
                        "number" => $number = !is_null( $prospect->phone->id ) ? $prospect->phone->getNicePhoneNumber() : "N/a",
                        "source" => $source,
                        "additional_info" => $additional_info = $hasMessage ? $input->get( "message" ) : "N/a",
                    ]
                );
            }

            // Add prospect message to prospect note
            if ( $hasMessage ) {
                $noteRegistrar->save(
                    "Message From Prospect: " . $input->get( "message" ),
                    $business->id,
                    $user_id = null,
                    $prospect_id = $prospect->id,
                    $member_id = null,
                    $appointemnt_id = null
                );
            }

            // Embeddable Form sequences
            $sequenceBuilder = $this->load( "sequence-builder" );
            $embeddableFormSequenceTemplateRepo = $this->load( "embeddable-form-sequence-template-repository" );
            $embeddableFormSequenceTemplates = $embeddableFormSequenceTemplateRepo->get(
                [ "*" ],
                [ "embeddable_form_id" => $embeddableForm->id ]
            );

            $sequenceBuilder->setRecipientName( $prospect->getFullName() )
                ->setSenderName( $business->business_name )
                ->setRecipientEmail( $prospect->email )
                ->setSenderEmail( $business->email )
                ->setRecipientPhoneNumber( $prospect->phone->getPhoneNumber() )
                ->setSenderPhoneNumber( $business->phone->getPhoneNumber() )
                ->setBusinessID( $business->id )
                ->setProspectID( $prospect->id );

            $timeZoneHelper = $this->load( "time-zone-helper" );

            $sequenceBuilder->setTimeZoneOffset(
                $timeZoneHelper->getServerTimeZoneOffset( $business->timezone )
            );

            foreach ( $embeddableFormSequenceTemplates as $embeddableFormSequenceTemplate ) {
                $sequenceBuilder->buildFromSequenceTemplate(
                    $embeddableFormSequenceTemplate->sequence_template_id
                );
            }

            if ( !is_null( $embeddableForm->redirect ) ) {
                $this->view->externalRedirect( $embeddableForm->redirect );
            }

            $this->view->redirect( "martial-arts-gyms/" . $business->id . "/" . "thank-you" );
        }
        // TODO This is tempory until user is redirect back to page from which they submitted the form
        $this->view->redirect( "martial-arts-gyms/" . $business->id . "/" . "thank-you?form-failure=true" );
    }
}
