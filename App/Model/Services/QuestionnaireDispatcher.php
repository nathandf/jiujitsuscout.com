<?php

namespace Model\Services;

use Model\Services\QuestionnaireRepository,
	Model\Services\QuestionRepository,
	Model\Services\QuestionChoiceRepository,
	Model\Services\QuestionChoiceTypeRepository,
	Model\Services\RespondentRepository,
	Model\Services\RespondentQuestionAnswerRepository;


class QuestionnaireDispatcher
{
	public $questionnareRepo;
	public $questionRepo;
	public $questionChoiceRepo;
	public $questionChoiceTypeRepo;
	public $respondentRepo;
	public $respondentQuestionAnswerRepo;
	public $respondent_token = null;
	public $questionnaire;

	public function __construct(
		QuestionnaireRepository $questionnaireRepo,
		QuestionRepository $questionRepo,
		QuestionChoiceRepository $questionChoiceRepo,
		QuestionChoiceTypeRepository $questionChoiceTypeRepo,
		RespondentRepository $respondentRepo,
		RespondentQuestionAnswerRepository $respondentQuestionAnswerRepo
	)
	{
		$this->questionnaireRepo = $questionnaireRepo;
		$this->questionRepo = $questionRepo;
		$this->questionChoiceRepo = $questionChoiceRepo;
		$this->questionChoiceTypeRepo = $questionChoiceTypeRepo;
		$this->respondentRepo = $respondentRepo;
		$this->respondentRepo = $respondentQuestionAnswerRepo;
	}

	public function dispatch( $questionnaire_id )
	{
		$questionnaire = $this->questionnaireRepo->getByID( $questionnaire_id );

		if ( !is_null( $questionnaire->id ) ) {

			$questionnaire->questions = $this->questionRepo->getAllByQuestionnaireID( $questionnaire->id );

			// Dynamically add a question_ids property
			$questionnaire->question_ids = [];

			foreach ( $questionnaire->questions as $question ) {
				$questionnaire->question_ids[] = $question->id;
				$question->question_choices = $this->questionChoiceRepo->getAllByQuestionID( $question->id );
				foreach ( $question->question_choices as $question_choice ) {
					$question_choice->question_choice_type = $this->questionChoiceTypeRepo->getByID( $question_choice->question_choice_type_id );
				}
			}

			$this->setQuestionnaire( $questionnaire );

			return;
		}

		throw new \Exception( "Questionnaire '{$questionnaire_id}' does not exist" );
	}

	private function setQuestionnaire( $questionnaire )
	{
		$this->questionnaire = $questionnaire;
	}

	public function getQuestionnaire()
	{
		if ( !isset( $this->questionnaire ) ) {
			throw new \Exception( "Questionnaire has not yet been dispatched" );
		}

		return $this->questionnaire;
	}
}
