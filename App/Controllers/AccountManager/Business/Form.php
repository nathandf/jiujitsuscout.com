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

        $this->view->assign( "account", $this->account );
        $this->view->assign( "user", $this->user );
        $this->view->assign( "business", $this->business );
    }

    public function indexAction()
    {
        if ( !$this->issetParam( "id" ) ) {
            $this->view->redirect( "account-manager/business/forms/" );
        }

        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );
        $HTMLFormBuilder = $this->load( "html-form-builder" );

        $embeddableForm = $embeddableFormRepo->getByID( $this->params[ "id" ] );
        $embeddableForm->elements = $embeddableFormElementRepo->getAllByEmbeddableFormID( $this->params[ "id" ] );

        $HTMLFormBuilder->setAction( "https://www.jiujitsuscout.com/form/" . $embeddableForm->token . "/new-prospect" );
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

        $this->view->assign( "form", $embeddableForm );
        $this->view->assign( "formHTML", $HTMLFormBuilder->getFormHTML() );

        $this->view->setTemplate( "account-manager/business/form/home.tpl" );
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
            ) )
        {
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
