<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Member extends Controller
{
    private $accountRepo;
    private $account;
    private $businessRepo;
    private $business;
    private $userRepo;
    private $user;

    public function before()
    {
        // Loading services
        $userAuth = $this->load( "user-authenticator" );
        $accountRepo = $this->load( "account-repository" );
        $accountUserRepo = $this->load( "account-user-repository" );
        $businessRepo = $this->load( "business-repository" );
        $userRepo = $this->load( "user-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $memberRepo = $this->load( "member-repository" );
        // If user not validated with session or cookie, send them to sign in
        if ( !$userAuth->userValidate() ) {
            $this->view->redirect( "account-manager/sign-in" );
        }
        // User is logged in. Get the user object from the UserAuthenticator service
        $this->user = $userAuth->getUser();

        // Get AccountUser reference
        $accountUser = $accountUserRepo->get( [ "*" ], [ "user_id" => $this->user->id ], "single" );

        // Grab account details
        $this->account = $accountRepo->get( [ "*" ], [ "id" => $accountUser->account_id ], "single" );

        // Grab business details
        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->user->getCurrentBusinessID() ], "single");

        $this->business->phone = $phoneRepo->get( [ "*" ], [ "id" => $this->business->phone_id ], "single" );

        if ( $this->issetParam( "id" ) ) {
            // Verify that this business owns this member
            $member_ids = $memberRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
            if ( !in_array( $this->params[ "id" ], $member_ids ) ) {
                $this->view->redirect( "account-manager/business/members" );
            }
            $this->member = $memberRepo->getByID( $this->params[ "id" ] );

            $this->member->phone = $phoneRepo->get( [ "*" ], [ "id" => $this->member->phone_id ], "single" );
            $this->member->setPhoneNumber( $this->member->phone->country_code, $this->member->phone->national_number );

            $this->view->assign( "member", $this->member );
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->build() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "../account-manager/business/member/new" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $noteRepo = $this->load( "note-repository" );
        $mailer = $this->load( "mailer" );
        $noteRegistrar = $this->load( "note-registrar" );
        $groupRepo = $this->load( "group-repository" );
        $emailTemplateRepo = $this->load( "email-template-repository" );
        $emailerHelper = $this->load( "emailer-helper" );

        // Get all notes for this member
        $notes = $noteRepo->getAllByMemberID( $this->member->id );

        // Create a list of all note ids.
        $note_ids = [];

        foreach ( $notes as $note ) {
            $note_ids[] = $note->id;
        }

        // Load all groups
        $groupsAll = $groupRepo->getAllByBusinessID( $this->business->id );
        $groups = [];
        $group_ids = explode( ",", $this->member->group_ids );
        foreach ( $groupsAll as $group ) {
            if ( in_array( $group->id, $group_ids ) ) {
                $groups[] = $group;
            }
        }

        // Set variables for sending an email
        $emailerHelper->setSenderName( $this->user->getFullName() );
        $emailerHelper->setSenderEmail( $this->user->email );
        $emailerHelper->setRecipientName( $this->member->getFullName());
        $emailerHelper->setRecipientEmail( $this->member->email );

        // Set email templates if any exist
        $emailerHelper->emailTemplates = $emailTemplateRepo->getAllByBusinessID( $this->business->id );

        if ( $input->exists() && $input->issetField( "send_email" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "subject" => [
                        "name" => "Subject",
                        "required" => true,
                        "min" => 1,
                        "max" => 500
                    ],
                    "body" => [
                        "name" => "Email Body",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "send_email" /* error index */
            ) )
        {
            // Prospect must have an email address to which to send the email
            if ( is_null( $this->member->email ) || $this->member->email == "" ) {
                $this->view->redirect( "account-manager/business/member/" . $this->member->id . "/?error=invalid_email" );
            }

            // Send email
            $email_subject = $input->get( "subject" );
            $email_body = $input->get( "body" );
            $mailer->setRecipientName( $emailerHelper->recipient_name );
            $mailer->setRecipientEmailAddress( $emailerHelper->recipient_email );
            $mailer->setSenderName( $emailerHelper->sender_name );
            $mailer->setSenderEmailAddress( $emailerHelper->sender_email );
            $mailer->setContentType( "text/html" );
            $mailer->setEmailSubject( $email_subject );
            $mailer->setEmailBody( $email_body );
            $mailer->mail();

            // Create a note for this interaction
            $note_body = "Sent with JiuJitsuScout: " . $input->get( "body" );
            $noteRegistrar->save( $note_body, $this->business->id, $this->user->id, null, $this->member->id );
            $this->view->redirect( "account-manager/business/member/" . $this->member->id . "/" );
        }

        if ( $input->exists() && $input->issetField( "add_note" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "add_note" => [
                        "required" => true
                    ],
                    "body" => [
                        "name" => "Note Body",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "add_note" /* error_index */

            ) )
        {
            $noteRegistrar->save( $input->get( "body" ), $this->business->id, $this->user->id, null, $this->member->id, null );
            $this->view->redirect( "account-manager/business/member/" . $this->member->id . "/" );
        }

        // Delete note from database if validation passes
        if ( $input->exists() && $input->issetField( "delete_note" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "note_id" => [
                        "name" => "Note ID",
                        "required" => true,
                        "in_array" => $note_ids
                    ]
                ],

                "delete_note" /* error index */
            ) )
        {
            $noteRepo->removeByID( $input->get( "note_id" ) );
            $this->view->redirect( "account-manager/business/member/" . $this->params[ "id" ] . "/#notes" );
        }

        $this->view->assign( "emailerHelper", $emailerHelper );

        $this->view->assign( "notes", $notes );

        $this->view->assign( "groups", $groups );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/member/member.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Member.php" );
    }

    public function chooseProspectAction()
    {
        $prospectRepo = $this->load( "prospect-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $prospects = $prospectRepo->getAllByStatusAndBusinessID( "pending", $this->business->id );

        // Load and set prospect's phone resource
        foreach ( $prospects as $prospect ) {
            $phone = $phoneRepo->getByID( $prospect->phone_id );
            $prospect->setPhoneNumber( $phone->country_code, $phone->national_number );
        }

        $this->view->assign( "leads", $prospects );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );

        $this->view->setTemplate( "account-manager/business/member/choose-prospect.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Member.php" );
    }

    public function newAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $entityFactory = $this->load( "entity-factory" );
        $memberRegistrar = $this->load( "member-registrar" );
        $phoneRepo = $this->load( "phone-repository" );
        $countryRepo = $this->load( "country-repository" );

        $country = $countryRepo->get( [ "*" ], [ "iso" => $this->account->country ], "single" );
        $countries = $countryRepo->get( [ "*" ] );

        if ( $input->exists() && $input->issetField( "register_member" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 250
                    ],
                    "last_name" => [
                        "name" => "Last Name",
                        "min" => 1,
                        "max" => 250
                    ],
                    "email" => [
                        "name" => "Email",
                        "email" => true
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "min" => 1,
                        "max" => 5
                    ],
                    "phone_number" => [
                        "name" => "Phone Number",
                        "phone" => true
                    ]
                ],

                "register_member" /* error index */
            ) )
        {
            $member = $entityFactory->build( "Member" );
            $member->business_id            = $this->business->id;
            $member->status                 = "active";
            $member->first_name  = trim( $input->get( "first_name" ) );
            $member->last_name              = $input->get( "last_name" );
            $member->email                  = $input->get( "email" );

            $phone = $phoneRepo->create( $input->get( "country_code" ), $input->get( "phone_number" ) );

            $member->phone_id               = $phone->id;
            $member->native_review          = 0;
            $member->google_review          = 0;
            $member->email_unsubscribe      = 0;
            $member->text_unsubscribe       = 0;
            $member->prospect_id            = null;
            // Save member and get new id
            $member = $memberRegistrar->register( $member );

            $this->view->redirect( "account-manager/business/member/" . $member->id . "/" );
        }

        // Set variables to populate inputs after form submission failure and assign to view
        $inputs = [];
        // add_note
        if ( $input->issetField( "register_member" ) ) {
            $inputs[ "register_member" ][ "first_name" ] = $input->get( "first_name" );
            $inputs[ "register_member" ][ "last_name" ] = $input->get( "last_name" );
            $inputs[ "register_member" ][ "email" ] = $input->get( "email" );
            $inputs[ "register_member" ][ "phone_number" ] = $input->get( "phone_number" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "countries", $countries );
        $this->view->assign( "country_code", $country->phonecode );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/member/add-member.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Member.php" );
    }

    public function convertProspectAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $factory = $this->load( "entity-factory" );
        $prospectRepo = $this->load( "prospect-repository" );
        $memberRegistrar = $this->load( "member-registrar" );

        // Verfiy that this business owns this prospect
        $prospects = $prospectRepo->getAllByBusinessID( $this->business->id );
        $prospect_ids = [];
        foreach ( $prospects as $prospect ) {
            $prospect_ids[] = $prospect->id;
        }

        if ( $input->exists( "get" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "name" => "Prospect ID",
                        "requred" => true,
                        "in_array" => $prospect_ids
                    ]
                ],

                "convert_prospect" /* error index */
            ) )
        {
            // Send back to chooseProspect method if current prospect is not owned by this business
            if ( !in_array( $input->get( "prospect_id" ), $prospect_ids ) ) {
                $this->view->redirect( "account-manager/business/member/choose-prospect" );
            }
            // build empty Member object
            $member = $factory->build( "Member" );
            $prospect = $prospectRepo->getByID( $input->get( "prospect_id" ) );
            $member->business_id = $this->business->id;

            // Register prospect as member
            $member = $memberRegistrar->registerProspect( $member, $prospect );

            // load full Prospect object
            $prospectRepo->updateTypeByID( "member", $prospect->id );
            $prospectRepo->updateStatusByID( "member", $prospect->id );


            $this->view->redirect( "account-manager/business/member/" . $member->id . "/" );
        }


        $this->view->redirect( "account-manager/business/member/choose-prospect" );
    }

    public function groupsAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $memberRepo = $this->load( "member-repository" );

        $all_groups = $groupRepo->getAllByBusinessID( $this->business->id );

        $member_group_ids = explode( ",", $this->member->group_ids );

        if ( $input->exists() ) {
            $group_ids = null;
            if ( $input->issetField( "group_ids" ) ) {
                $group_ids = implode( ",", $input->get( "group_ids" ) );
            }
            $memberRepo->updateGroupIDsByID( $group_ids, $this->params[ "id" ] );

            $this->view->redirect( "account-manager/business/member/" . $this->member->id . "/groups" );
        }

        foreach ( $all_groups as $group ) {
            $group->isset = false;
            if ( in_array( $group->id, $member_group_ids ) ) {
                $group->isset = true;
            }
        }

        $this->view->assign( "groups", $all_groups );

        $this->view->setTemplate( "account-manager/business/member/groups.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Member.php" );
    }

    public function editAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $memberRepo = $this->load( "member-repository" );
        $phoneRepo = $this->load( "phone-repository" );
        $countryRepo = $this->load( "country-repository" );
        $entityFactory = $this->load( "entity-factory" );

        $phone = $phoneRepo->getByID( $this->member->phone_id );

        $country = $countryRepo->get( [ "*" ], [ "iso" => $this->account->country ], "single" );

        $countries = $countryRepo->get( [ "*" ] );

        $member_ids = $memberRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        if ( $input->exists() && $input->issetField( "update_member" ) && $inputValidator->validate( $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_member" => [
                        "required" => true
                    ],
                    "first_name" => [
                        "name" => "First Name",
                        "required" => true
                    ],
                    "last_name" => [
                        "name" => "Last Name",
                    ],
                    "email" => [
                        "name" => "Email",
                        "email" => true
                    ],
                    "country_code" => [
                        "name" => "Country Code",
                        "min" => 1,
                        "max" => 5
                    ],
                    "phone_number" => [
                        "name" => "Phone Number",
                        "phone" => true
                    ],
                    "address_1" => [
                        "name" => "Address 1"
                    ],
                    "address_2" => [
                        "name" => "Address 2"
                    ],
                    "city" => [
                        "name" => "City"
                    ],
                    "region" => [
                        "name" => "Region"
                    ]
                ],

                "edit_member" /* error index */
            ) )
        {
            $member = $entityFactory->build( "Member" );
            $member->first_name = $input->get( "first_name" );
            $member->last_name = $input->get( "last_name" );
            $member->email = $input->get( "email" );

            $phone->country_code = $input->get( "country_code" );
            $phone->national_number = $input->get( "phone_number" );
            $phoneRepo->updateByID( $phone, $this->member->phone_id );

            $member->address_1 = $input->get( "address_1" );
            $member->address_2 = $input->get( "address_2" );
            $member->city = $input->get( "city" );
            $member->region = $input->get( "region" );
            $memberRepo->updateMemberByID( $this->member->id, $member );
            $this->view->redirect( "account-manager/business/member/" . $this->member->id . "/edit" );
        }

        if ( $input->exists() && $input->issetField( "trash" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "trash" => [
                        "required" => true
                    ],
                    "member_id" => [
                        "required" => true,
                        "in_array" => $member_ids
                    ]
                ],
                "trash_member" /* error */
            ) )
        {
            $memberRepo->delete( [ "id" ], [ $this->member->id ] );
            $this->session->addFlashMessage( $this->member->getFullName() . " deleted successfully" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/members" );
        }

        $this->view->assign( "phone", $phone );
        $this->view->assign( "countries", $countries );
        $this->view->assign( "member", $this->member );


        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/member/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Member.php" );
    }

    public function sequencesAction()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $businessSequenceRepo = $this->load( "business-sequence-repository" );
        $memberSequenceRepo = $this->load( "member-sequence-repository" );
        $sequenceTemplateSequenceRepo = $this->load( "sequence-template-sequence-repository" );
        $sequenceRepo = $this->load( "sequence-repository" );

        // Get all sequences for this member
        $memberSequences = $memberSequenceRepo->get( [ "*" ], [ "member_id" => $this->member->id ] );
        $sequenceTemplates = $sequenceTemplateRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );

        $activeSequenceTemplates = [];
        $active_sequence_template_ids = [];
        $inactiveSequenceTemplates = [];
        $completedSequenceTemplates = [];
        $completed_sequence_template_ids = [];

        // Populate an array ($activeSequenceTemplates) with all sequence templates
        // from which this member's sequences were created.
        foreach ( $memberSequences as $memberSequence ) {
            $sequence_template_id = $sequenceTemplateSequenceRepo->get( [ "sequence_template_id" ], [ "sequence_id" => $memberSequence->sequence_id ], "single" )->sequence_template_id;
            $sequenceTemplate = $sequenceTemplateRepo->get( [ "*" ], [ "id" => $sequence_template_id ], "single" );
            $sequenceTemplate->sequence = $sequenceRepo->get( [ "*" ], [ "id" => $memberSequence->sequence_id ], "single" );

            if ( $sequenceTemplate->sequence->complete ) {
                $completedSequenceTemplates[] = $sequenceTemplate;
                $completed_sequence_template_ids[] = $sequence_template_id;

                continue;
            }

            $activeSequenceTemplates[] = $sequenceTemplate;
            $active_sequence_template_ids[] = $sequence_template_id;
        }

        // Populate an array ($inactiveSequenceTemplates) will all sequence templates
        // that have not been used to genertate sequences for this member
        foreach ( $sequenceTemplates as $sequenceTemplate ) {
            if ( !in_array( $sequenceTemplate->id, $active_sequence_template_ids ) ) {
                $inactiveSequenceTemplates[] = $sequenceTemplate;
            }
        }

        if ( $input->exists() && $input->issetField( "add_to_sequence" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ],
                    "sequence_template_id" => [
                        "required" => true,
                        "in_array" => $sequenceTemplateRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" )
                    ],
                    "quantity" => [
                        "numeric" => true
                    ],
                    "unit" => [
                        "in_array" => [ "days", "weeks", "months" ]
                    ]
                ],
                "add_to_sequence"
            )
        ) {
            $sequenceBuilder = $this->load( "sequence-builder" );

            $sequenceBuilder->setRecipientName( $this->member->getFullName() )
                ->setSenderName( $this->business->business_name )
                ->setRecipientEmail( $this->member->email )
                ->setSenderEmail( $this->business->email )
                ->setRecipientPhoneNumber( $this->member->phone->getPhoneNumber() )
                ->setSenderPhoneNumber( $this->business->phone->getPhoneNumber() )
                ->setBusinessID( $this->business->id )
                ->setMemberID( $this->params[ "id" ] );
                
            // Set start time
            if ( $input->issetField( "unit" ) && $input->issetField( "quantity" ) ) {
                $sequenceBuilder->setStartTime(
                    strtotime( "+{$input->get( "quantity" )} {$input->get( "unit" )}" )
                );
            }

            // If a sequence was built successfully, create a member and business
            // sequence reference and redirect to the sequence screen
            $sequenceTemplate = $sequenceTemplateRepo->get( [ "*" ], [ "id" => $input->get( "sequence_template_id" ) ], "single" );

            if ( $sequenceBuilder->buildFromSequenceTemplate( $sequenceTemplate->id ) ) {
                $sequence = $sequenceBuilder->getSequence();

                // Inform user of successful sequence creation
                $this->session->addFlashMessage( "{$this->member->getFullName()} has been added to sequenece '{$sequenceTemplate->name}'" );
                $this->session->setFlashMessages();

                // Redirect back to the "choose sequence" page
                $this->view->redirect( "account-manager/business/member/" . $this->params[ "id" ] . "/sequences" );
            }

            // If sequence build fails, get the error messages from the sequence
            // builder and set them to the input validator
            $errorMessages = $sequenceBuilder->getErrorMessages();
            foreach ( $errorMessages as $message ) {
                $inputValidator->addError( "add_to_sequence", $message );
            }

        }

        if ( $input->exists() && $input->issetField( "sequence_id" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "required" => true,
                        "equals-hidden" => $this->session->getSession( "csrf-token" )
                    ],
                    "sequence_id" => [
                        "required" => true
                    ]
                ],
                "delete_sequence"
            )
        ) {
            $sequenceDestroyer = $this->load( "sequence-destroyer" );
            $eventDestroyer = $this->load( "event-destroyer" );

            $sequenceDestroyer->destroy( $input->get( "sequence_id" ) );
            $eventDestroyer->destroyBySequenceID( $input->get( "sequence_id" ) );

            $this->session->addFlashMessage( "{$this->member->getFullName()} successfully removed from sequence." );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/member/" . $this->params[ "id" ] . "/sequences" );
        }

        $this->view->assign( "activeSequenceTemplates", $activeSequenceTemplates );
        $this->view->assign( "inactiveSequenceTemplates", $inactiveSequenceTemplates );
        $this->view->assign( "completedSequenceTemplates", $completedSequenceTemplates );
        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->assign( "error_messages", $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/member/sequences.tpl" );
        $this->view->render( "App/Views/AccountManager/Business.php" );
    }
}
