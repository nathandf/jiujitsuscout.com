<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class LandingPage extends Controller
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
        $landingPageRepo = $this->load( "landing-page-repository" );
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
        $landing_pages = $landingPageRepo->getAllByBusinessID( $this->business->id );
        $landing_page_ids = [];
        foreach ( $landing_pages as $landing_page ) {
            $landing_page_ids[] = $landing_page->id;
        }
        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $landing_page_ids ) ) {
            $this->view->redirect( "account-manager/business/landing-pages/" );
        }

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/landing-pages/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $groupRepo = $this->load( "group-repository" );
        $landingPageRepo = $this->load( "landing-page-repository" );
        $landingPageGroupRepo = $this->load( "landing-page-group-repository" );

        $groupsAll = $groupRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $group_ids_all = $groupRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );

        $landingPage = $landingPageRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );
        $landingPageGroups = $landingPageGroupRepo->get( [ "*" ], [ "landing_page_id" => $landingPage->id ] );
        $landing_page_group_group_ids = $landingPageGroupRepo->get( [ "group_id" ], [ "landing_page_id" => $landingPage->id ], "raw" );

        $facebook_pixel_active = false;
        if ( !is_null( $landingPage->facebook_pixel_id ) && $landingPage->facebook_pixel_id != "" ) {
            $facebook_pixel_active = true;
        }

        if ( $input->exists() ) {
            // Update groups
            $submitted_group_ids = [];
            if ( $input->issetField( "group_ids" ) ) {
                $submitted_group_ids = $input->get( "group_ids" );
            }

            // Create and new landing page group for any of the submitted
            // group ids if it doesn't already exist
            foreach ( $submitted_group_ids as $group_id ) {
                if ( !in_array( $group_id, $landing_page_group_group_ids, true ) ) {
                    $landingPageGroupRepo->insert([
                        "landing_page_id" => $landingPage->id,
                        "group_id" => $group_id
                    ]);
                }
            }

            // Delete the landing page groups with the group ids that were not
            // submitted
            foreach ( $group_ids_all as $_group_id ) {
                if (
                    !in_array( $_group_id, $submitted_group_ids ) &&
                    in_array( $_group_id, $landing_page_group_group_ids, true )
                ) {
                    $landingPageGroupRepo->delete( [ "group_id" ], [ $_group_id ] );
                }
            }

            // Facebook Pixel
            if ( $input->issetField( "facebook_pixel_track" ) ) {
                if ( !is_null( $this->business->facebook_pixel_id ) && $this->business->facebook_pixel_id != "" ) {
                    $landingPageRepo->updateFacebookPixelIDByID( $this->business->facebook_pixel_id, $landingPage->id );
                }
            } else {
                $landingPageRepo->updateFacebookPixelIDByID( null, $landingPage->id );
            }

            if ( $inputValidator->validate(

                    $input,

                    [
                        "token" => [
                            "equals-hidden" => $this->session->getSession( "csrf-token" ),
                            "required" => true
                        ],
                        "update_landing_page" => [
                            "required" => true
                        ],
                        "name" => [
                            "name" => "Landing Page Name",
                            "required" => true,
                            "min" => 1,
                            "max" => 200
                        ],
                        "slug" => [
                            "name" => "Slug",
                            "required" => true,
                            "min" => 1,
                            "max" => 100,
                            "uri" => true
                        ]
                    ],

                    "update_landing_page" /* error index */
                ) )
            {
                $landingPageRepo->updateNameByID( $input->get( "name" ), $this->params[ "id" ] );
                $landingPageRepo->modifySlug( $input->get( "slug" ), $this->params[ "id" ], $this->business->id );
                $this->view->redirect( "account-manager/business/landing-page/" . $landingPage->id . "/" );
            }
        }

        foreach ( $groupsAll as $group ) {
            $group->isset = false;
            if ( in_array( $group->id, $landing_page_group_group_ids ) ) {
                $group->isset = true;
            }
        }

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "facebook_pixel_active", $facebook_pixel_active );
        $this->view->assign( "groups", $groupsAll );
        $this->view->assign( "page", $landingPage );

        $this->view->setTemplate( "account-manager/business/landing-page/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/LandingPage.php" );
    }

    public function chooseTemplateAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/landing-page/" . $this->param[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $templateRepo = $this->load( "landing-page-template-repository" );

        $templates = $templateRepo->getAll();

        $this->view->assign( "templates", $templates );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/landing-page/choose-template.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/LandingPage.php" );
    }

    public function previewAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/landing-pages/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $landingPageRepo = $this->load( "landing-page-repository" );

        $landingPage = $landingPageRepo->getByID( $this->params[ "id" ] );

        if ( empty( $landingPage->id ) ) {
            $this->view->redirect( "account-manager/business/landing-pages/" );
        }

        $this->view->assign( "preview_active", true );
        $this->view->assign( "page", $landingPage );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "martial-arts-gyms/landing-page-templates/" . $landingPage->template_file );
        $this->view->render( "App/Views/AccountManager/Business/LandingPage.php" );
    }

    public function viewTemplateAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/landing-page/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $landingPageTemplateRepo = $this->load( "landing-page-template-repository" );

        $landingPageTemplates = $landingPageTemplateRepo->getAll();

        $template_ids = [];
        foreach ( $landingPageTemplates as $template ) {
            $template_ids[] = $template->id;
        }

        if ( $input->exists( "get" ) && $inputValidator->validate( $input,
                [
                    "template_id" => [
                        "required" => true,
                        "in_array" => $template_ids
                    ]
                ], null /* error index */
            ) )
        {
            $template = $landingPageTemplateRepo->getByID( $input->get( "template_id" ) );

            // Create a mock page with mock data
            $page = new \StdClass;
            $page->headline = "This is the Headline";
            $page->text_a = "Text Section A";
            $page->text_b = "Text Section B";
            $page->text_c = "Text Section C";
            $page->text_form = "Form text goes here!";
            $page->call_to_action = "Call to action goes here";
            $page->call_to_action_form = "Form button call to action here";
            $page->image_background = "";
            $page->image_a = "";
            $page->image_b = "";
            $page->image_c = "";

            $total_template_ids = count( $template_ids );

            $current_template_id = $template->id;
            $current_index = array_search( $template->id, $template_ids );

            if ( $current_index == ( $total_template_ids - 1 ) ) {
                $next_template_id = $template_ids[ 0 ];
                $previous_template_id = $template_ids[ $current_index - 1 ];
            } elseif ( $current_index == 0 ) {
                $previous_template_id = $template_ids[ $total_template_ids - 1 ];
                $next_template_id = $template_ids[ $current_index + 1 ];
            } else {
                $previous_template_id = $template_ids[ $current_index - 1 ];
                $next_template_id = $template_ids[ $current_index + 1 ];
            }

            $this->view->assign( "current_template_id", $current_template_id );
            $this->view->assign( "previous_template_id", $previous_template_id );
            $this->view->assign( "next_template_id", $next_template_id );
            $this->view->assign( "template_view_active", true );
            $this->view->assign( "template", $template );
            $this->view->assign( "page", $page );

            $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
            $this->view->setErrorMessages( $inputValidator->getErrors() );

            $this->view->setTemplate( "martial-arts-gyms/landing-page-templates/" . $template->template_filename );
            $this->view->render( "App/Views/AccountManager/Business/LandingPage.php" );
        } else {
            $this->view->redirect( "account-manager/business/landing-page/choose-template?error=invalid_template_id" );
        }
    }

    public function buildAction()
    {
        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/landing-page/" . $this->params[ "id" ] . "/" );
        }

        // Load helpers and services
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $imageManager = $this->load( "image-manager" );
        $landingPageRepo = $this->load( "landing-page-repository" );
        $landingPageTemplateRepo = $this->load( "landing-page-template-repository" );

        $landingPageTemplates = $landingPageTemplateRepo->getAll();
        $slugs = $landingPageRepo->getAllSlugsByBusinessID( $this->business->id );

        $template_ids = [];
        foreach ( $landingPageTemplates as $template ) {
            $template_ids[] = $template->id;
        }

        // This variable will be added on to the redirect
        $slug_warning = "";

        if ( $input->exists( "get" ) && $inputValidator->validate(

                $input,

                [
                    "template_id" => [
                        "required" => true,
                        "in_array" => $template_ids
                    ]
                ],

                null /* error index */

            ) )
        {
            $template = $landingPageTemplateRepo->getByID( $input->get( "template_id" ) );

            // Create a mock page with mock data
            $page = new \StdClass;
            $page->headline = "This is the Headline";
            $page->text_a = "Text Section A";
            $page->text_b = "Text Section B";
            $page->text_c = "Text Section C";
            $page->text_form = "Form text goes here!";
            $page->call_to_action = "Call to action goes here";
            $page->call_to_action_form = "Form button call to action here";
            $page->image_background = "http://placehold.it/550x270&text=No+Attachment!";
            $page->image_a = "http://placehold.it/550x270&text=No+Attachment!";
            $page->image_b = "http://placehold.it/550x270&text=No+Attachment!";
            $page->image_c = "http://placehold.it/550x270&text=No+Attachment!";

            // Load all groups by id
            $groupRepo = $this->load( "group-repository" );
            $groups = $groupRepo->getAllByBusinessID( $this->business->id );

        } else {
            $this->view->redirect( "account-manager/business/landing-page/choose-template?error=invalid_template_id" );
        }

        // Check for a GET request with all variables set. Allow any variable to be empty
        if ( $input->exists() && $input->issetField( "create_landing_page" ) && $inputValidator->validate(

                $input,

                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Landing Page Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 250
                    ],
                    "slug" => [
                        "name" => "Slug",
                        "required" => true,
                        "min" => 1,
                        "max" => 250,
                        "unique" => $slugs
                    ],
                    "template_id" => [
                        "name" => "Template Id",
                        "required" => true,
                        "in_array" => $template_ids
                    ],
                    "headline" => [
                        "name" => "Headline",
                    ],
                    "text_a" => [
                        "name" => "Text A",
                        "max" => 500
                    ],
                    "text_b" => [
                        "name" => "Text B",
                        "max" => 500
                    ],
                    "text_c" => [
                        "name" => "Text C",
                        "max" => 500
                    ],
                    "text_form" => [
                        "name" => "Form Text",
                        "max" => 500
                    ],
                    "call_to_action" => [
                        "name" => "Call-to-action Button",
                        "required" => true,
                        "min" => 1,
                        "max" => 100
                    ],
                    "call_to_action_form" => [
                        "name" => "Form Call-to-action Button",
                        "required" => true,
                        "min" => 1,
                        "max" => 100
                    ]
                ],

                "create_landing_page" /* error index */
            ) )
        {
            $template = $landingPageTemplateRepo->getByID( $input->get( "template_id" ) );

            // Get slug and check if available. If not, set slug equal to hashed timestamp
            $slug = trim( $input->get( "slug" ) );

            if ( $landingPageRepo->checkSlugAvailability( $slug, $this->business->id ) === false ) {
                $slug_warning = "?error=slug_warning";
                $slug = md5( time() );
            }
            // Save images to img/uploads
            $image_indices = [ "image_a", "image_b", "image_c", "image_background" ];
            $image_names = [];
            foreach ( $image_indices as $index ) {
                if ( isset( $_FILES[ $index ] ) && !empty( $_FILES[ $index ][ "type" ] ) ) {
                    $imageManager->saveImageTo( $index, "public/img/uploads/" );
                    $image_name = $imageManager->getNewImageFileName();
                    $image_names[ $index ] = $image_name;
                } else {
                    $image_names[ $index ] = null;
                }
            }

            // Add the new landing page to the DB
            $landingPage = $landingPageRepo->create(
                $slug,
                $input->get( "name" ),
                $this->business->id,
                [],
                null,
                $input->get( "call_to_action" ),
                $input->get( "call_to_action_form" ),
                $input->get( "headline" ),
                $input->get( "text_a" ),
                $input->get( "text_b" ),
                $input->get( "text_c" ),
                $input->get( "text_form" ),
                $image_names[ "image_background" ],
                $image_names[ "image_a" ],
                $image_names[ "image_b" ],
                $image_names[ "image_c" ],
                $template->template_filename );

            // Redirect to the landing page's update page
            $this->view->redirect( "account-manager/business/landing-page/" . $landingPage->id . "/" . $slug_warning );
        }

        $inputs = [];

        // update_landing_page
        if ( $input->issetField( "create_landing_page" ) ) {
            $inputs[ "create_landing_page" ][ "name" ] = $input->get( "name" );
            $inputs[ "create_landing_page" ][ "slug" ] = $input->get( "slug" );
            $inputs[ "create_landing_page" ][ "headline" ] = $input->get( "headline" );
            $inputs[ "create_landing_page" ][ "text_a" ] = $input->get( "text_a" );
            $inputs[ "create_landing_page" ][ "text_b" ] = $input->get( "text_b" );
            $inputs[ "create_landing_page" ][ "text_c" ] = $input->get( "text_c" );
            $inputs[ "create_landing_page" ][ "text_form" ] = $input->get( "text_form" );
            $inputs[ "create_landing_page" ][ "call_to_action" ] = $input->get( "call_to_action" );
            $inputs[ "create_landing_page" ][ "call_to_action_form" ] = $input->get( "call_to_action_form" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->assign( "groups", $groups );
        $this->view->assign( "creator_active", true );
        $this->view->assign( "template", $template );
        $this->view->assign( "page", $page );

        $this->view->setTemplate( "martial-arts-gyms/landing-page-templates/" . $template->template_filename );
        $this->view->render( "App/Views/AccountManager/Business/LandingPage.php" );

    }

}
