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
        $accountUser = $accountUserRepo->getByUserID( $this->user->id );

        // Grab account details
        $this->account = $accountRepo->getByID( $accountUser->account_id );

        // Grab business details
        $this->business = $businessRepo->getByID( $this->user->getCurrentBusinessID() );

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

        $HTMLFormBuilder->setAction( "https://www.jiujitsuscout.com/forms/" );
        $HTMLFormBuilder->setToken( "this-is-the-token" );

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
                    ]
                ],

                "create_form" /* error index */
            ) )
        {
            $embeddableForm = $embeddableFormRepo->create( $this->business->id, trim( $input->get( "name" ) ) );
            $this->view->redirect( "account-manager/business/form/" . $embeddableForm->id . "/edit" );
        }

        $inputs = [];

        if ( $input->issetField( "create_form" ) ) {
            $inputs[ "create_form" ][ "name" ] = $input->get( "name" );
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
        $embeddableFormElementTypeRepo = $this->load( "embeddable-form-element-type-repository" );
        $embeddableFormElementRepo = $this->load( "embeddable-form-element-repository" );
        $embeddableFormRepo = $this->load( "embeddable-form-repository" );

        echo "edit";
    }

}
