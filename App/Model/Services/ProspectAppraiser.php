<?php

namespace Model\Services;

use Model\Services\QuestionChoiceWeightRepository,
    Model\Services\RespondentRepository,
	Model\Services\RespondentQuestionAnswerRepository,
    Model\Services\ProspectAppraisalRepository,
    Model\Services\ProspectAppraiserDetailsRepository;

class ProspectAppraiser
{
	public $questionChoiceWeightRepo;
	public $respondentRepo;
	public $respondentQuestionAnswerRepo;
    public $prospectAppraisalRepo;
    public $prospectAppraiserDetailsRepository;
	public $prospect_price = 5;
	public $base_question_value = 1;

	public function __construct(
		QuestionChoiceWeightRepository $questionChoiceWeightRepo,
		RespondentRepository $respondentRepo,
		RespondentQuestionAnswerRepository $respondentQuestionAnswerRepo,
        ProspectAppraisalRepository $prospectAppraisalRepo,
        ProspectAppraiserDetailsRepository $prospectAppraiserDetailsRepo
	)
	{
		$this->questionChoiceWeightRepo = $questionChoiceWeightRepo;
		$this->respondentRepo = $respondentRepo;
		$this->respondentQuestionAnswerRepo = $respondentQuestionAnswerRepo;
        $this->prospectAppraisalRepo = $prospectAppraisalRepo;
        $this->prospectAppraiserDetaislRepo = $prospectAppraiserDetailsRepo;
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

        $this->prospectAppraisalRepo->create( $prospect->id, $this->prospect_price );

		return $this->prospect_price;
	}

	public function updateProspectPrice( $value_to_be_weighted, $weight = 1 )
	{
		$this->prospect_price = $this->prospect_price + ( $value_to_be_weighted * $weight );
	}
}
