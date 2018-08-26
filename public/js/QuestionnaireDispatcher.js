var QuestionnaireDispatcher  = {
    question_ids: null,
	total_questions: null,
	current_question_id: null,
	current_question_index: null,
	active_question_html_id: null,
	active_form_html_id: null,
	active_submit_button_html_id: null,
    active_question_choice_label_class: null,
    active_question_choice_input_class: null,

	dispatch: function ( question_ids, current_question_id ) {
		this.setQuestionIDs( question_ids );
		this.setCurrentQuestionID( current_question_id );
		this.setCurrentQuestionIndex();
		this.setTotalQuestions();
		this.setActiveQuestionHTMLID();
        this.setActiveQuestionChoiceLabelClass();
        this.setActiveQuestionChoiceInputClass();
		this.setActiveFormHTMLID();
		this.setActiveSubmitButtonID();
	},

    setQuestionIDs: function ( question_ids ) {
		this.question_ids = question_ids;
    },

	getQuestionID: function ( index ) {
		return this.question_ids[ index ];
	},

	setTotalQuestions: function () {
		this.total_questions = this.question_ids.length;
	},

	setCurrentQuestionID: function ( current_question_id ) {
		this.current_question_id = current_question_id;
	},

	setCurrentQuestionIndex: function () {
		this.current_question_index = this.question_ids.indexOf(
			this.current_question_id.toString()
		)
	},

	setActiveQuestionHTMLID: function () {
		this.active_question_html_id = "#question_" + this.current_question_id;
	},

	setActiveFormHTMLID: function () {
		this.active_form_html_id = "#question_form_" + this.current_question_id;
	},

    setActiveQuestionChoiceLabelClass: function () {
		this.active_question_choice_label_class = ".question-choice-label-" + this.current_question_id;
	},

    setActiveQuestionChoiceInputClass: function () {
		this.active_question_choice_input_class = ".question-choice-input-" + this.current_question_id;
	},

	setActiveSubmitButtonID: function () {
		this.active_submit_button_html_id = "#question_submit_" + this.current_question_id;
	},

	nextQuestion: function () {
		this.current_question_index++;
		this.setCurrentQuestionID( this.getQuestionID( this.current_question_index ) );
		this.setCurrentQuestionIndex();
		this.setActiveQuestionHTMLID();
        this.setActiveQuestionChoiceLabelClass();
        this.setActiveQuestionChoiceInputClass();
		this.setActiveFormHTMLID();
		this.setActiveSubmitButtonID();
	},
};
