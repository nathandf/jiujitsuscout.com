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
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

        // Verify that this business owns this landing page
        $groups = $groupRepo->getAllByBusinessID( $this->business->id );
        $group_ids = [];
        foreach ( $groups as $group ) {
            $group_ids[] = $group->id;
        }
        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $group_ids ) ) {
            $this->view->redirect( "account-manager/business/groups/" );
        }

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
        $memberRepo = $this->load( "member-repository" );
        $phoneRepo = $this->load( "phone-repository" );

        // Get all prospects
        $prospectsAll = $prospectRepo->getAllByBusinessID( $this->business->id );
        $prospects = [];
        $prospect_ids = [];

        // Get all members
        $membersAll = $memberRepo->getAllByBusinessID( $this->business->id );
        $members = [];
        $member_ids = [];

        $group = $groupRepo->getByID( $this->params[ "id" ] );

        // Filter all prospects that belong to this group
        foreach ( $prospectsAll as $prospect ) {
            $groups = explode( ",", $prospect->group_ids );
            if ( in_array( $group->id, $groups ) && $prospect->type != "member" ) {
                $prospects[] = $prospect;
            }
        }

        // Load all phone resources for prospects
        foreach ( $prospects as $prospect ) {
            $phone =  $phoneRepo->getByID( $prospect->phone_id );
            $prospect->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
            $prospect_ids[] = $prospect->id;
        }

        // Filter all members that belong to this group
        foreach ( $membersAll as $member ) {
            $groups = explode( ",", $member->group_ids );
            if ( in_array( $group->id, $groups ) ) {
                $members[] = $member;
            }
        }

        // Load all phone resources for members
        foreach ( $members as $member ) {
            $phone =  $phoneRepo->getByID( $member->phone_id );
            $member->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
            $member_ids[] = $member->id;
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
            ) )
        {
            $prospect = $prospectRepo->getByID( $input->get( "prospect_id" ) );
            $group_ids = explode( ",", $prospect->group_ids );

            // Remove group from prospect's group_ids
            foreach ( $group_ids as $key => $group_id ) {
                if ( $group_id == $this->params[ "id" ] ) {
                    unset( $group_ids[ $key ] );
                }
            }

            $group_ids = implode( ",", $group_ids );
            $prospectRepo->updateGroupIDsByID( $group_ids, $prospect->id );

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
            ) )
        {
            $member = $memberRepo->getByID( $input->get( "member_id" ) );
            $group_ids = explode( ",", $member->group_ids );

            // Remove group from member's group_ids
            foreach ( $group_ids as $key => $group_id ) {
                if ( $group_id == $this->params[ "id" ] ) {
                    unset( $group_ids[ $key ] );
                }
            }

            $group_ids = implode( ",", $group_ids );
            $memberRepo->updateGroupIDsByID( $group_ids, $member->id );

            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/" );
        }

        $this->view->assign( "leads", $prospects );
        $this->view->assign( "members", $members );
        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

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
            ) )
        {
            $group = $groupRepo->create( $this->business->id, $input->get( "name" ), $input->get( "description" ) );
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
        $prospectRepo = $this->load( "prospect-repository" );
        $memberRepo = $this->load( "member-repository" );
        $landingPageRepo = $this->load( "landing-page-repository" );

        $groupsAll = $groupRepo->getAllByBusinessID( $this->business->id );
        $group_ids = [];

        foreach ( $groupsAll as $group ) {
            $group_ids[] = $group->id;
        }

        // Set group from query string param
        $group = $groupRepo->getByID( $this->params[ "id" ] );

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
            ) )
        {
            $groupRepo->updateGroupByID( $this->params[ "id" ], $input->get( "name" ), $input->get( "description" ) );
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
            ) )
        {
            $prospects = $prospectRepo->getAllByBusinessID( $this->business->id );
            $members = $memberRepo->getAllByBusinessID( $this->business->id );
            $landingPages = $landingPageRepo->getAllByBusinessID( $this->business->id );

            // Remove this group from group_ids of all prospects
            foreach ( $prospects as $prospect ) {
                $group_ids = explode( ",", $prospect->group_ids );
                foreach ( $group_ids as $key => $id ) {
                    if ( $id == $input->get( "group_id" ) ) {
                        unset( $group_ids[ $key ] );
                    }
                }
                $group_ids = implode( ",", $group_ids );
                $prospectRepo->updateGroupIDsByID( $group_ids, $prospect->id );
            }

            // Remove this group from group_ids of all members
            foreach ( $members as $member ) {
                $group_ids = explode( ",", $member->group_ids );
                foreach ( $group_ids as $key => $id ) {
                    if ( $id == $input->get( "group_id" ) ) {
                        unset( $group_ids[ $key ] );
                    }
                }
                $group_ids = implode( ",", $group_ids );
                $memberRepo->updateGroupIDsByID( $group_ids, $member->id );
            }

            // Remove this group from group_ids of all landing pages
            foreach ( $landingPages as $landingPage ) {
                $group_ids = explode( ",", $landingPage->group_ids );
                foreach ( $group_ids as $key => $id ) {
                    if ( $id == $input->get( "group_id" ) ) {
                        unset( $group_ids[ $key ] );
                    }
                }
                $group_ids = implode( ",", $group_ids );
                $landingPageRepo->updateGroupIDsByID( $group_ids, $landingPage->id );
            }

            $groupRepo->removeByID( $input->get( "group_id" ) );
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
        $phoneRepo = $this->load( "phone-repository" );

        // Get all prospects
        $prospectsAll = $prospectRepo->getAllByBusinessID( $this->business->id );
        $prospects = [];
        $prospect_ids = [];

        $group = $groupRepo->getByID( $this->params[ "id" ] );

        // Load all phone resources for prospects and set prospect id array
        foreach ( $prospectsAll as $prospect ) {
            // Filter prospects that have current group id
            if ( !in_array( $this->params[ "id" ], explode( ",", $prospect->group_ids ) ) && $prospect->type != "member" && $prospect->type != "trash" ) {
                $prospects[] = $prospect;
                $phone =  $phoneRepo->getByID( $prospect->phone_id );
                $prospect->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
                $prospect_ids[] = $prospect->id;
            }
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
                        "in_array" => $prospect_ids
                    ]
                ],

                "choose_prospect" /* error index */
            ) )
        {
            $prospect = $prospectRepo->getByID( $input->get( "prospect_id" ) );
            $group_ids = explode( ",", $prospect->group_ids );
            $group_ids[] = $this->params[ "id" ];
            $group_ids = implode( ",", $group_ids );
            $prospectRepo->updateGroupIDsByID( $group_ids, $prospect->id );
            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/#lead{$prospect->id}" );
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
        $phoneRepo = $this->load( "phone-repository" );

        // Get all members
        $membersAll = $memberRepo->getAllByBusinessID( $this->business->id );
        $members = [];
        $member_ids = [];

        $group = $groupRepo->getByID( $this->params[ "id" ] );

        // Load all phone resources for members and set member id array
        foreach ( $membersAll as $member ) {
            // Filter members that have current group id
            if ( !in_array( $this->params[ "id" ], explode( ",", $member->group_ids ) ) ) {
                $members[] = $member;
                $phone =  $phoneRepo->getByID( $member->phone_id );
                $member->phone_number = "+" . $phone->country_code . " " . $phone->national_number;
                $member_ids[] = $member->id;
            }
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
                        "in_array" => $member_ids
                    ]
                ],

                "choose_member" /* error index */
            ) )
        {
            $member = $memberRepo->getByID( $input->get( "member_id" ) );
            $group_ids = explode( ",", $member->group_ids );
            $group_ids[] = $this->params[ "id" ];
            $group_ids = implode( ",", $group_ids );
            $memberRepo->updateGroupIDsByID( $group_ids, $member->id );
            $this->view->redirect( "account-manager/business/group/" . $this->params[ "id" ] . "/#member{$member->id}" );
        }

        $this->view->assign( "members", $members );
        $this->view->assign( "group", $group );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/group/choose-member.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Group.php" );
    }
}
