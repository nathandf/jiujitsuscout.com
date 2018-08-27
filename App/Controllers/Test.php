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

            // Create a respondent with this questionnaire_id and respondent token
            $respondentRepo->create( $questionnaire->id, $respondent_token );
        }

        // Load the respondent object
        $respondent = $respondentRepo->getByToken( $respondent_token );

        // Dispatch the questionnaire and return the questionnaire object
        $questionnaireDispatcher->dispatch( 1 );
        $questionnaire = $questionnaireDispatcher->getQuestionnaire();

        $this->view->assign( "questionnaire", $questionnaire );
        $this->view->assign( "respondent", $respondent );

        $this->view->setTemplate( "test/questionnaire.tpl" );
		$this->view->render( "App/Views/Home.php" );
    }

    public function questionnaires()
    {
        $input = $this->load( "input" );
        $inputValidator = $this->load( "input-validator" );
        $respondentRepo = $this->load( "respondent-repository" );
        $respondentQuestionAnswerRepo = $this->load( "respondent-question-answer-repository" );

        if ( $input->exists() && $inputValidator->validate(
            $input,
            [
                "respondent_id" => [
                    "required" => true
                ],
                "question_id" => [
                    "required" => true
                ],
                "question_choice_ids" => [
                    "is_array" => true
                ],
                "text" => [
                    "min" => 1,
                    "max" => 1023
                ]
            ],
            "questionnaire" /* error index */
            ) )
        {
            $question_choice_ids = $input->get( "question_choice_ids" );

            foreach ( $question_choice_ids as $question_choice_id ) {
                $respondentQuestionAnswerRepo->create(
                    $input->get( "respondent_id" ),
                    $input->get( "question_id" ),
                    $question_choice_id,
                    $text = $input->get( "text" )
                );
            }

            $respondentRepo->updateLastQuestionIDByID(
                $input->get( "respondent_id" ),
                $input->get( "question_id" )
            );
        }
    }
}
