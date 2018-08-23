{extends file="layouts/core.tpl"}

{block name="head"}
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	<script src="{$HOME}{$JS_SCRIPTS}questionnaire.js"></script>
	<script>
		{literal}
		$( function() {
			var question_ids = {/literal}{$questionnaire->question_ids|@json_encode}{literal};
			var current_question_id = {/literal}{$questionnaire->current_question_id}{literal};
			var current_question_index = question_ids.indexOf( current_question_id.toString() );
			var active_question_html_id;

			$( ".questionnaire-submit" ).on( "click", function () {
				active_question_html_id = "#question_" + question_ids[ current_question_index ];
				$( active_question_html_id ).toggle();
				current_question_index++;
				active_question_html_id = "#question_" + question_ids[ current_question_index ];
				$( active_question_html_id ).toggle();
			} );
		} );
		{/literal}
	</script>
{/block}

{block name="body"}
	<div class="con-cnt-med-plus-plus bg-white mat-box-shadow inner-pad-med push-t-lrg questionnaire">
		{foreach from=$questionnaire->questions item=question name=question_loop}
		<div id="question_{$question->id}" class="{if $smarty.foreach.question_loop.iteration != 1} inactive-question{/if}">
			<div class="questionnaire-wrapper">
				<p class="text-sml push-b-sml">Question {$smarty.foreach.question_loop.iteration} of {$questionnaire->questions|@count}</p>
			</div>
			<form action="" method="get">
				<input type="hidden" name="respondent_id" value="{$respondent->id}">
				<input type="hidden" name="question_id" value="{$question->id}">
				<h2 class="questionnaire-question">{$question->text}</h2>
				<div class="questionnaire-question-choices">
					{foreach from=$question->question_choices item=choice}
						<input style="display: none;" id="question_{$question->id}_question_choice_{$choice->id}" type="radio" name="question_choice_id" value="{$choice->id}" required="requried">
						<label for="question_{$question->id}_question_choice_{$choice->id}" style="display: block;" class="questionnaire-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">{$choice->text}</label>
					{/foreach}
				</div>
				<div class="questionnaire-wrapper">
					<button id="question_submit_{$question->id}" type="button" class="questionnaire-submit btn push-t-med"><span class="text-xlrg">Continue</span></button>
					<div class="clear"></div>
				</div>
			</form>
		</div>
		{/foreach}
	</div>
{/block}
