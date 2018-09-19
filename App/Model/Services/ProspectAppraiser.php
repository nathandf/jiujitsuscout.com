<?php

namespace Model\Services;

use Model\Services\QuestionChoiceWeightRepository,
    Model\Services\RespondentRepository,
	Model\Services\RespondentQuestionAnswerRepo;

class ProspectAppraiser
{
	public $questionChoiceWeightRepo;
	public $respondentRepo;
	public $respondentQuestionAnswerRepo;
	// TODO Add prospect appraisal details to the Model
	public $prospect_price = 5;
	public $base_question_value = 1;

	public function __construct(
		QuestionChoiceWeightRepository $questionChoiceWeightRepo,
		RespondentRepository $respondentRepo,
		RespondentQuestionAnswerRepository $respondentQuestionAnswerRepo
	)
	{
		$this->questionChoiceWeightRepo = $questionChoiceWeightRepo;
		$this->respondentRepo = $respondentRepo;
		$this->respondentQuestionAnswerRepo = $respondentQuestionAnswerRepo;
	}

	public function appraise( \Model\Prospect $prospect )
	{
		// Get a responent resource related to this prospect if one exists
		$respondent = $this->respondentRepo->getByProspectID( $prospect->id );

		// Get all answers to the questions they completed
		$respondentQuestionAnswers = $this->respondentQuestionAnswerRepo->getAllByRespondentID(
			$respondent->id
		);

		foreach ( $respondentQuestionAnswers as $respondentQuestionAnswer ) {
			$questionChoiceWeight = $this->questionChoiceWeightRepo->getByQuestionChoiceID(
				$respondentQuestionAnswer->question_choice_id
			);

			$this->updateProspectPrice( $this->base_question_value, $questionChoiceWeight->weight );
		}

		return $this->prospect_price;
	}

	public function updateProspectPrice( $value_to_be_weighted, $weight = 1 )
	{
		$this->prospect_price = $this->prospect_price + ( $value_to_be_weighted * $weight );
	}
}
