<?php

namespace Controllers;

use \Core\Controller;

class Test extends Controller
{
    public function braintree()
	{
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
		$productRepo = $this->load( "product-repository" );

        $products = $productRepo->getAll();

        $this->view->assign( "products", $products );

		$this->view->assign( "csrf_token", $this->session->generateCSRFToken() );
	    $this->view->setErrorMessages( $inputValidator->getErrors() );

		$this->view->setTemplate( "braintree-test.tpl" );
		$this->view->render( "App/Views/Home.php" );
	}

    public function sequenceDispatcherAction()
    {
        $sequenceManager = $this->load( "sequence-dispatcher" );
        $sequenceManager->dispatch();
    }

    public function questionnaireDispatcher()
    {
        $respondentRepo = $this->load( "respondent-repository" );
        $questionnaireDispatcher = $this->load( "questionnaire-dispatcher" );

        // Check session for a respondent token. If one doesnt exit, create a
        // new respondent and dispatch the questionnaire. If a respondent does
        // exist, load the respodent and pass through the last question id to
        // start the questionnaire where that respondent left off.
        $respondent_token = $this->session->getSession( "respondent-token" );

        if ( is_null( $respondent_token ) ) {

            // Generate a new token
            $respondent_token = $this->session->generateToken();

            // Set the session with the new respondent token
            $this->session->setSession( "respondent-token", $respondent_token );

            // Dispatch the questionnaire and return the questionnaire object
            $questionnaireDispatcher->dispatch( 1 );
            $questionnaire = $questionnaireDispatcher->getQuestionnaire();

            // Create a respondent with this questionnaire_id and respondent token
            $respondent = $respondentRepo->create( $questionnaire->id, $respondent_token );
        } else {

            // Load the respondent object
            $respondent = $respondentRepo->getByToken( $respondent_token );

            // Dispatch the questionnaire using the last_question_di and return
            // the questionnaire object
            $questionnaireDispatcher->dispatch( 1, $respondent->last_question_id );
            $questionnaire = $questionnaireDispatcher->getQuestionnaire();
        }

        $this->view->assign( "questionnaire", $questionnaire );
        $this->view->assign( "respondent", $respondent );

        $this->view->setTemplate( "test/questionnaire.tpl" );
		$this->view->render( "App/Views/Home.php" );
    }

    public function questionnaires()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $respondentRepo = $this->load( "respondent-repo" );
        $respndentQuestionAnswerRepo = $this->load( "respondent-question-answer-repo" );

        if ( $input->exists() && $input->issetField( "" ) && $inputValidator->validate(
            $input,
            [
                "respondent_id" => [
                    "required" => true
                ],
                "question_id" => [
                    "required" => true
                ],
                "question_choice_id" => [
                    "required" => true
                ]
            ],
            "questionnaire" /* error index */
            ) )
        {
            //
        }
    }
}
