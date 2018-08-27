{extends file="layouts/core.tpl"}

{block name="head"}
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
	<script>
		{literal}
		$( function() {
			QuestionnaireDispatcher.dispatch(
				{/literal}{$questionnaire->question_ids|@json_encode}{literal},
				{/literal}{$respondent->last_question_id}{literal}
			);

			$( ".questionnaire-question-choice" ).on( "click", function ( event ) {
				QuestionnaireDispatcher.toggleSubmitButton( event );
			} );

			$( ".questionnaire-submit" ).on( "click", function () {
				QuestionnaireDispatcher.submitQuestionAnswer( "questionnaires" );
			} );
		} );
		{/literal}
	</script>
{/block}

{block name="body"}
	<div class="con-cnt-med-plus-plus bg-white mat-box-shadow inner-pad-med push-t-lrg questionnaire">
		{foreach from=$questionnaire->questions item=question name=question_loop}
		<div id="question_{$question->id}" class="inactive-question">
			<div class="questionnaire-wrapper">
				<p class="text-sml push-b-sml">Question {$smarty.foreach.question_loop.iteration} of {$questionnaire->questions|@count}</p>
			</div>
			<form id="question_form_{$question->id}" action="" method="post">
				<input type="hidden" name="respondent_id" value="{$respondent->id}">
				<input type="hidden" name="question_id" value="{$question->id}">
				<h2 class="questionnaire-question">{$question->text}</h2>
				<div class="questionnaire-question-choices">
					{foreach from=$question->question_choices item=choice}
						<input class="question-choice-input-{$question->id} question-choice-input" style="display: none;" id="question_{$question->id}_question_choice_{$choice->id}" type="{if $choice->question_choice_type_id == 1}radio{else}checkbox{/if}" name="question_choice_ids[]" value="{$choice->id}">
						<label for="question_{$question->id}_question_choice_{$choice->id}" style="display: block;" class="questionnaire-question-choice question-choice-label-{$question->id} mat-hov inner-pad-sml push-t-med cursor-pt h3">{$choice->text}</label>
					{/foreach}
				</div>
				<div class="questionnaire-wrapper">
					<button style="display: none;" id="question_submit_{$question->id}" type="submit" class="questionnaire-submit btn push-t-med"><span class="text-xlrg">Continue</span></button>
					<div class="clear"></div>
				</div>
			</form>
		</div>
		{/foreach}
	</div>
{/block}
