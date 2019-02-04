<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Group extends Controller
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
        $groupRepo = $this->load( "group-repository" );
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
        $this->business = $businessRepo->get( [ "*" ], [ "id" => $this->user->getCurrentBusinessID() ], "single" );

        // Verify that this business owns this landing page
        $groups = $groupRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $group_ids = $groupRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $group_ids ) ) {
            $this->view->redirect( "account-manager/business/groups/" );
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
            $this->view->redirect( "account-manager/business/groups/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $prospectGroupRepo = $this->load( "prospect-group-repository" );
        $memberGroupRepo = $this->load( "member-group-repository" );
        $memberRepo = $this->load( "member-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $group = $groupRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        // Get all prospects
        $prospect_ids = $prospectGroupRepo->get( [ "prospect_id" ], [ "group_id" => $this->params[ "id" ] ], "raw" );
        $prospects = [];
        foreach ( $prospect_ids as $prospect_id ) {
            $prospect = $prospectRepo->get( [ "*" ], [ "id" => $prospect_id ], "single" );
            if ( $prospect->type != "member" ) {
                $phone =  $phoneRepo->get( [ "*" ], [ "id" => $prospect->phone_id ], "single" );
                $prospect->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
                $prospects[] = $prospect;
            }
        }

        // Get all members
        $member_ids = $memberGroupRepo->get( [ "member_id" ], [ "group_id" => $this->params[ "id" ] ], "raw" );
        $members = [];
        foreach ( $member_ids as $member_id ) {
            $member = $memberRepo->get( [ "*" ], [ "id" => $member_id ], "single" );
            $phone =  $phoneRepo->get( [ "*" ], [ "id" => $member->phone_id ], "single" );
            $member->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
            $members[] = $member;
        }

        if ( $input->exists() && $input->issetField( "remove_prospect" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals_hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true,
                        "in_array" => $prospect_ids
                    ]
                ],
                "remove_prospect"
            )
        ) {
            $prospectGroupRepo->delete( [ "prospect_id", "group_id" ], [ $input->get( "prospect_id" ), $this->params[ "id" ] ] );
            $this->session->addFlashMessage( "Lead removed from Group" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        if ( $input->exists() && $input->issetField( "remove_member" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals_hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "member_id" => [
                        "required" => true,
                        "in_array" => $member_ids
                    ]
                ],
                "remove_member"
            )
        ) {
            $memberGroupRepo->delete( [ "member_id", "group_id" ], [ $input->get( "member_id" ), $this->params[ "id" ] ] );
            $this->session->addFlashMessage( "Member removed from Group" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "leads", $prospects );
        $this->view->assign( "members", $members );
        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/group/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }

    public function newAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "create_group" => [
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Group Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "description" => [
                        "name" => "Description",
                        "required" => true,
                        "min" => 1,
                        "max" => 1000
                    ]
                ],

                "create_group" /* error index */
            )
        ) {
            $group = $groupRepo->insert([
                "business_id" => $this->business->id,
                "name" => $input->get( "name" ),
                "description" => $input->get( "description" )
            ]);

            $this->session->addFlashMessage( "Group Created" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/group/" . $group->id . "/" );
        }

        $inputs = [];

        // update_landing_page
        if ( $input->issetField( "create_group" ) ) {
            $inputs[ "create_group" ][ "name" ] = $input->get( "name" );
            $inputs[ "create_group" ][ "description" ] = $input->get( "description" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/group/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }

    public function editAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/groups/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $prospectGroupRepo = $this->load( "prospect-group-repository" );
        $memberGroupRepo = $this->load( "member-group-repository" );
        $landingPageGroupRepo = $this->load( "landing-page-group-repository" );

        // Set group from query string param
        $group = $groupRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        $group_ids = $groupRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        if ( $input->exists() && $input->issetField( "update_group" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "update_group" => [
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Group Name",
                        "required" => true
                    ],
                    "description" => [
                        "name" => "Description",
                    ],
                ],
                "edit_group" /* error index */
            )
        ) {
            $groupRepo->update(
                [
                    "name" => $input->get( "name" ),
                    "description" => $input->get( "description" )
                ],
                [ "id" => $this->params[ "id" ] ]
            );
            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/edit" );
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
                    "group_id" => [
                        "required" => true,
                        "in_array" => $group_ids
                    ]
                ],
                "delete_group" /* error index */
            )
        ) {
            $embeddableFormGroupRepo = $this->load( "embeddable-form-group-repository" );
            $memberGroupRepo->delete( [ "group_id" ], [ $this->params[ "id" ] ] );
            $prospectGroupRepo->delete( [ "group_id" ], [ $this->params[ "id" ] ] );
            $landingPageGroupRepo->delete( [ "group_id" ], [ $this->params[ "id" ] ] );
            $embeddableFormGroupRepo->delete( [ "group_id" ], [ $this->params[ "id" ] ] );
            $groupRepo->delete( [ "id" ], [ "id" => $input->get( "group_id" ) ] );

            $this->session->addFlashMessage( "Group '{$group->name}' Deleted" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/groups/" );
        }

        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/group/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }

    public function chooseProspectAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/groups/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $prospectRepo = $this->load( "prospect-repository" );
        $prospectGroupRepo = $this->load( "prospect-group-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $group = $groupRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        // Get all prospects
        $prospect_ids_all = $prospectRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $prospect_ids = $prospectGroupRepo->get( [ "prospect_id" ], [ "group_id" => $this->params[ "id" ] ], "raw" );
        $prospectsAll = $prospectRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $prospects = [];

        foreach ( $prospectsAll as $_prospect ) {
            if ( in_array( $_prospect->id, $prospect_ids ) || $_prospect->type != "lead" ) {
                continue;
            }

            $prospects[] = $_prospect;
        }

        if ( $input->exists() && $input->issetField( "prospect_id" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "prospect_id" => [
                        "required" => true,
                        "in_array" => $prospect_ids_all
                    ]
                ],
                "choose_prospect" /* error index */
            )
        ) {
            $prospectGroupRepo->insert([
                "prospect_id" => $input->get( "prospect_id" ),
                "group_id" => $this->params[ "id" ]
            ]);
            $this->session->addFlashMessage( "Lead Added" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "leads", $prospects );
        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/group/choose-prospect.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }

    public function chooseMemberAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/groups/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $memberRepo = $this->load( "member-repository" );
        $memberGroupRepo = $this->load( "member-group-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        $group = $groupRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );

        // Get all members
        $member_ids_all = $memberRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $member_ids = $memberGroupRepo->get( [ "member_id" ], [ "group_id" => $this->params[ "id" ] ], "raw" );
        $membersAll = $memberRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $members = [];

        foreach ( $membersAll as $_member ) {
            if ( in_array( $_member->id, $member_ids ) ) {
                continue;
            }

            $members[] = $_member;
        }

        if ( $input->exists() && $input->issetField( "member_id" ) && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "member_id" => [
                        "required" => true,
                        "in_array" => $member_ids_all
                    ]
                ],
                "choose_member" /* error index */
            )
        ) {
            $memberGroupRepo->insert([
                "member_id" => $input->get( "member_id" ),
                "group_id" => $this->params[ "id" ]
            ]);
            $this->session->addFlashMessage( "Member Added" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "members", $members );
        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/group/choose-member.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }
}
