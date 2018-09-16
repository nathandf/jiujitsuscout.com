{if isset($questionnaire)}
<script>
	{literal}
		$( function() {
			// If an element exists with the --q-trigger class, dispatch the
			// questionnaire when it is clicked. It it doesn't exists, trigger
			// the questionnaire right away
			if ( $( ".--q-trigger" ).length ) {
				$( ".--q-trigger" ).on( "click", function () {
					// If questionnaire dispatched, show questonnaire, else,
					// dispatch questionnaire
					if ( QuestionnaireDispatcher.questionnaire_dispatched ) {
						if ( QuestionnaireDispatcher.questionnaire_complete == false || QuestionnaireDispatcher.questionnaire_complete == null ) {
							$( ".questionnaire" ).show();
						}
					} else {
						QuestionnaireDispatcher.dispatch(
							{/literal}{$questionnaire->question_ids|@json_encode}{literal},
							{/literal}{$respondent->last_question_id|default:0}{literal},
							{/literal}{$respondent->questionnaire_complete|default:0}{literal},
							"{/literal}{$HOME}{literal}questionnaire/submit-question"
						);
					}

				} );
			}

			$( ".questionnaire-close" ).on( "click", function () {
	            $( ".questionnaire" ).hide();
	        } );
		} );
	{/literal}
</script>

<div style="display: none;" class="questionnaire">
	<p class="questionnaire-close text-xlrg-heavy tc-white inner-pad-med cursor-pt push-r floatright"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear"></div>
	<div class="con-cnt-med-plus-plus bg-white mat-box-shadow questionnaire-container">
		{foreach from=$questionnaire->questions item=question name=question_loop}
		<div id="question_{$question->id}" class="inactive-question" style="padding-top: 20px;">
			<div class="questionnaire-wrapper">
				<p class="text-sml push-b-sml">Question {$smarty.foreach.question_loop.iteration} of {$questionnaire->questions|@count}</p>
			</div>
			<form id="question_form_{$question->id}" action="" method="post">
				{if $smarty.foreach.question_loop.last}
				<input type="hidden" name="questionnaire_complete" value="true">
				{/if}
				<input type="hidden" name="respondent_id" value="{$respondent->id}">
				<input type="hidden" name="question_id" value="{$question->id}">
				<h2 class="questionnaire-question">{$question->text}</h2>
				<div class="questionnaire-question-choice-container">
					{foreach from=$question->question_choices item=choice}
						{if $choice->question_choice_type_id == 1}
						<input class="question-choice-input-{$question->id} question-choice-input" style="display: none;" id="question_{$question->id}_question_choice_{$choice->id}" type="radio" name="question_choice_ids[]" value="{$choice->id}">
						<label for="question_{$question->id}_question_choice_{$choice->id}" style="display: block;" class="questionnaire-question-choice question-choice-label-{$question->id} mat-hov inner-pad-sml push-t-med cursor-pt h3">{$choice->text}</label>
						{elseif $choice->question_choice_type_id == 2}
						<input class="question-choice-input-{$question->id} question-choice-input" style="display: none;" id="question_{$question->id}_question_choice_{$choice->id}" type="checkbox" name="question_choice_ids[]" value="{$choice->id}">
						<label for="question_{$question->id}_question_choice_{$choice->id}" style="display: block;" class="questionnaire-question-choice question-choice-label-{$question->id} mat-hov inner-pad-sml push-t-med cursor-pt h3">{$choice->text}</label>
						{elseif $choice->question_choice_type_id == 3}
						<input class="question-choice-input-{$question->id} question-choice-input" style="display: none;" id="question_{$question->id}_question_choice_{$choice->id}" type="radio" name="question_choice_ids[]" value="{$choice->id}">
						<label for="question_{$question->id}_question_choice_{$choice->id}" style="display: block;" class="questionnaire-question-choice question-choice-label-{$question->id} mat-hov inner-pad-sml push-t-med cursor-pt h3">{$choice->text}</label>
						<div class="questionnaire-wrapper">
							<textarea name="text" style="padding: 10px; box-sizing: border-box; width: 100%; border: 1px solid #DDD; border-radius: 3px; margin-top: 10px; height: 60px;" id="" cols="30" rows="10"></textarea>
						</div>
						{/if}
					{/foreach}
				</div>
				<div class="questionnaire-submit-container">
					<div class="questionnaire-wrapper">
						<button style="display: none;" id="question_submit_{$question->id}" type="submit" class="questionnaire-submit btn push-t-med{if $smarty.foreach.question_loop.last} questionnaire-complete-button{/if}"><span class="text-xlrg">{if $smarty.foreach.question_loop.last}Complete{else}Continue{/if}</span></button>
						<div class="clear"></div>
					</div>
				</div>
			</form>
		</div>
		{/foreach}
	</div>
</div>
{/if}
