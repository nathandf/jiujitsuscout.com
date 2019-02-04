<?php

namespace Controllers\AccountManager\Business;

use Core\Controller;

class Form extends Controller
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

        $embeddableFormRepo = $this->load( "embeddable-form-repository" );

        $embeddableForms = $embeddableFormRepo->getAllByBusinessID( $this->business->id );
        $embeddableFormIDs = [];

        foreach ( $embeddableForms as $form ) {
            $embeddableFormIDs[] = $form->id;
        }

        if ( isset( $this->params[ "id" ] ) && !in_array( $this->params[ "id" ], $embeddableFormIDs ) ) {
            $this->view->redirect( "account-manager/business/forms/" );
        }

        // Track with facebook pixel
		$Config = $this->load( "config" );
		$facebookPixelBuilder = $this->load( "facebook-pixel-builder" );

		$facebookPixelBuilder->addPixelID( $Config::$configs[ "facebook" ][ "jjs_pixel_id" ] );
		$this->view->assign( "facebook_pixel", $facebookPixelBuilder->buildPixel() );

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/forms/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $sequenceTemplateRepo = $this->load( "sequence-template-repository" );
        $groupRepo = $this->load( "group-repository" );
        $embeddableFormSequenceTemplateRepo = $this->load( "embeddable-form-sequence-template-repository" );
        $embeddableFormGroupRepo = $this->load( "embeddable-form-group-repository" );

        $embeddableForm = $embeddableFormRepo->get( [ "*" ], [ "id" => $this->params[ "id" ] ], "single" );
        $embeddableForm = $embeddableFormRepo->getByID( $this->params[ "id" ] );
        $formCode = "<iframe src=\"" . HOME . "forms/{$this->business->id}/{$embeddableForm->token}\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"width: 100%; max-width: 600px; height: 400px;\">Loading...</iframe>";

        $sequenceTemplates = $sequenceTemplateRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $sequence_template_ids_all = $sequenceTemplateRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $sequence_template_ids = $embeddableFormSequenceTemplateRepo->get( [ "sequence_template_id" ], [ "embeddable_form_id" => $this->params[ "id" ] ], "raw" );

        foreach ( $sequenceTemplates as $sequenceTemplate ) {
            $sequenceTemplate->isset = false;
            if ( in_array( $sequenceTemplate->id, $sequence_template_ids ) ) {
                $sequenceTemplate->isset = true;
            }
        }

        $groups = $groupRepo->get( [ "*" ], [ "business_id" => $this->business->id ] );
        $group_ids_all = $groupRepo->get( [ "id" ], [ "business_id" => $this->business->id ], "raw" );
        $group_ids = $embeddableFormGroupRepo->get( [ "group_id" ], [ "embeddable_form_id" => $this->params[ "id" ] ], "raw" );

        foreach ( $groups as $group ) {
            $group->isset = false;
            if ( in_array( $group->id, $group_ids ) ) {
                $group->isset = true;
            }
        }

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "update_embeddable_form" => [
                    "required" => true
                ]
            ],

            "update_sequence_templates" /* error index */
            )
        ) {
            // Update embeddable form sequence template
            $submitted_sequence_template_ids = [];
            if ( $input->issetField( "sequence_template_ids" ) ) {
                $submitted_sequence_template_ids = $input->get( "sequence_template_ids" );
            }

            // Create and new embeddable form sequence template for any of the submitted
            // sequence tepmlate ids if it doesn't already exist
            foreach ( $submitted_sequence_template_ids as $submitted_sequence_template_id ) {
                if ( !in_array( $submitted_sequence_template_id, $sequence_template_ids, true ) ) {
                    $embeddableFormSequenceTemplateRepo->insert([
                        "embeddable_form_id" => $embeddableForm->id,
                        "sequence_template_id" => $submitted_sequence_template_id
                    ]);
                }
            }

            // Delete the embeddable form sequence templates with the sequence template ids that were not
            // submitted
            foreach ( $sequence_template_ids_all as $_sequence_template_id ) {
                if (
                    !in_array( $_sequence_template_id, $submitted_sequence_template_ids ) &&
                    in_array( $_sequence_template_id, $sequence_template_ids, true )
                ) {
                    $embeddableFormSequenceTemplateRepo->delete( [ "sequence_template_id", "embeddable_form_id" ], [ $_sequence_template_id, $this->params[ "id" ] ] );
                }
            }

            // Update embeddable form groups
            $submitted_group_ids = [];
            if ( $input->issetField( "group_ids" ) ) {
                $submitted_group_ids = $input->get( "group_ids" );
            }

            // Create and new embeddable form group for any of the submitted
            // group ids if it doesn't already exist
            foreach ( $submitted_group_ids as $submitted_group_id ) {
                if ( !in_array( $submitted_group_id, $group_ids, true ) ) {
                    $embeddableFormGroupRepo->insert([
                        "embeddable_form_id" => $embeddableForm->id,
                        "group_id" => $submitted_group_id
                    ]);
                }
            }

            // Delete the embeddable form groups with the group ids that were not
            // submitted
            foreach ( $group_ids_all as $_group_id ) {
                if (
                    !in_array( $_group_id, $submitted_group_ids ) &&
                    in_array( $_group_id, $group_ids, true )
                ) {
                    $embeddableFormGroupRepo->delete( [ "group_id", "embeddable_form_id" ], [ $_group_id, $this->params[ "id" ] ] );
                }
            }

            $this->session->addFlashMessage( "Form Updated" );
            $this->session->setFlashMessages();

            $this->view->redirect( "account-manager/business/form/" . $embeddableForm->id . "/" );
        }

        $this->view->assign( "form", $embeddableForm );
        $this->view->assign( "form_code", htmlentities( $formCode ) );
        $this->view->assign( "sequence_templates", $sequenceTemplates );
        $this->view->assign( "groups", $groups );
        $this->view->assign( "csrf_token", $this->session->getSession( "csrf-token" ) );
        $this->view->assign( "flash_messages", $this->session->getFlashMessages() );

        $this->view->setTemplate( "account-manager/business/form/home.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Form.php" );
    }

    public function viewAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/forms/" );
        }

        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $HTMLFormBuilder = $this->load( "html-form-builder" );

        $embeddableForm = $embeddableFormRepo->getByID( $this->params[ "id" ] );

        $HTMLFormBuilder->setAction( "https://www.jiujitsuscout.com/form/{$embeddableForm->token}/" );
        $HTMLFormBuilder->setToken( $embeddableForm->token )
			->setApplicationPrefix( "EmbeddableFormWidgetByJiuJitsuScout__" )
			->setJavascriptResourceURL( "https://www.jiujitsuscout.com/public/static/js/embeddable-form.js" )
			->setFormOffer( $embeddableForm->offer );

        $this->view->assign( "form", $embeddableForm );
        $this->view->assign( "form_code", htmlspecialchars_decode( $HTMLFormBuilder->getFormHTML() ) );

        $this->view->setTemplate( "account-manager/business/form/view-form.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Form.php" );
    }

    public function newAction()
    {

        if ( $this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/form/" . $this->params[ "id" ] . "/" );
        }

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );

        if ( $input->exists() && $inputValidator->validate(
                $input,
                [
                    "token" => [
                        "equals-hidden" => $this->session->getSession( "csrf-token" ),
                        "required" => true
                    ],
                    "create_form" => [
                        "required" => true
                    ],
                    "name" => [
                        "name" => "Form Name",
                        "required" => true,
                        "min" => 1,
                        "max" => 200,
                    ],
                    "offer" => [
                        "name" => "Offer",
                        "required" => true,
                        "max" => 256
                    ]
                ],
                "create_form" /* error index */
            )
        ) {
            $embeddableForm = $embeddableFormRepo->create( $this->business->id, trim( $input->get( "name" ) ), $input->get( "offer" ) );
            $this->view->redirect( "account-manager/business/form/" . $embeddableForm->id . "/edit" );
        }

        $inputs = [];

        if ( $input->issetField( "create_form" ) ) {
            $inputs[ "create_form" ][ "name" ] = $input->get( "name" );
            $inputs[ "create_form" ][ "offer" ] = $input->get( "offer" );
        }

        // Input values submitted from form
        $this->view->assign( "inputs", $inputs );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/form/new.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Forms.php" );
    }

    public function editAction()
    {
        // Render 404 if 'id' is not present
        $this->requireParam( "id" );

        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $HTMLFormBuilder = $this->load( "html-form-builder" );

        // Get the current form
        $embeddableForm = $embeddableFormRepo->getByID( $this->params[ "id" ] );

        // Get all elements for this form
        $embeddableFormElements = $embeddableFormElementRepo->getAllByEmbeddableFormID( $this->params[ "id" ] );

        // Add an elements property to form
        $embeddableForm->elements = $embeddableFormElements;

        // Prepare a preview of the form
        $HTMLFormBuilder->setAction( "https://jiujitsuscout.com/form/" . $embeddableForm->token . "/new-prospect" );
        $HTMLFormBuilder->setToken( $embeddableForm->token );
        $HTMLFormBuilder->setApplicationPrefix( "EmbeddableFormWidgetByJiuJitsuScout__" );
        $HTMLFormBuilder->setJavascriptResourceURL( "https://www.jiujitsuscout.com/public/static/js/embeddable-form.js" );
        $HTMLFormBuilder->setFormOffer( $embeddableForm->offer );

        if ( !empty( $embeddableForm->elements ) ) {
            foreach ( $embeddableForm->elements as $element ) {
                $element->type = $embeddableFormElementTypeRepo->getByID( $element->embeddable_form_element_type_id );
                $HTMLFormBuilder->addField(
                    $element->type->name,
                    $element->type->name,
                    $required = $element->required ? true : false,
                    $text = $element->text,
                    $value = null
                );
            }
        }

        // Get the placement of the next element to be created
        $lastElement = end( $embeddableFormElements );
        $new_element_placement = $lastElement != false ? ( $lastElement->placement + 1 ) : 1;

        // Get all form element types
        $embeddableFormElementTypes = $embeddableFormElementTypeRepo->getAll();

        // 1. Assign respective form element type objects to elements and create
        // a define a name property for the input
        //
        // 2. Create an array of embeddableFormElementType ids that are in use
        // in the current form
        $usedEmbeddableFormElementTypeIDs = [];
        foreach ( $embeddableFormElements as $embeddableFormElement ) {
            // 1.
            $embeddableFormElement->type = $embeddableFormElementTypeRepo->getByID(
                $embeddableFormElement->embeddable_form_element_type_id
            );
            $embeddableFormElement->name_property = preg_replace( "/[\s]+/", "_", trim( strtolower( $embeddableFormElement->type->name ) ) );
            // 2.
            $usedEmbeddableFormElementTypeIDs[] = $embeddableFormElement->embeddable_form_element_type_id;
        }

        // 1. Create an array of all form element type ids. This will be used later
        // to ensure that user submitted formElementTypeIDs are valid
        //
        // 2. Create an array of embeddableFormElementsTypes that have not been used
        // on the current form
        $embeddableFormElementTypeIDs = [];
        $availableEmbeddableFormElementTypes = [];
        foreach ( $embeddableFormElementTypes as $type ) {
            // 1.
            $embeddableFormElementTypeIDs[] = $type->id;
            // 2.
            if ( !in_array( $type->id, $usedEmbeddableFormElementTypeIDs ) ) {
                $availableEmbeddableFormElementTypes[] = $type;
            }
        }

        if ( $input->exists() && $input->issetField( "add_field" )  && $inputValidator->validate(
            $input,
            [
                "token" => [
                    "equals-hidden" => $this->session->getSession( "csrf-token" ),
                    "required" => true
                ],
                "placement" => [
                    "required" => true
                ],
                "embeddable_form_element_type_id" => [
                    "required" => true,
                    "in_array" => $embeddableFormElementTypeIDs
                ],
                "required" => [
                    "min" => 1
                ]
            ],
            "add_field"
            )
        ) {
            $embeddableFormElementRepo->create(
                $this->params[ "id" ],
                $input->get( "embeddable_form_element_type_id" ),
                $input->get( "placement" ),
                null,
                $required = ( $input->get( "required" ) == "true" ) ? true : false
            );

            $this->view->redirect( "account-manager/business/form/" . $this->params[ "id" ] . "/edit" );
        }

        $this->view->assign( "form", $embeddableForm );
        $this->view->assign( "formHTML", $HTMLFormBuilder->getFormHTML() );
        $this->view->assign( "new_element_placement", $new_element_placement );
        $this->view->assign( "embeddableFormElements", $embeddableFormElements );
        $this->view->assign( "availableEmbeddableFormElementTypes", $availableEmbeddableFormElementTypes );

        $this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
        $this->view->setErrorMessages( $inputValidator->getErrors() );

        $this->view->setTemplate( "account-manager/business/form/edit.tpl" );
        $this->view->render( "App/Views/AccountManager/Business/Form.php" );
    }

}
