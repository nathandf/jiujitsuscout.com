{extends file="layouts/core.tpl"}

{block name="head"}
	<script src="{$HOME}{$JS_SCRIPTS}self-schedule.js"></script>
	<link rel="stylesheet" href="{$HOME}public/css/self-schedule.css">
{/block}

{block name="body"}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con-cnt-med-plus-plus">
		<div class="inner-pad-med bg-white push-t-lrg push-b-lrg mat-box-shadow" style="border: 2px solid #CCCCCC;">
			<h2 class="title-wrapper">Schedule your first class</h2>
			<div class="hr-full"></div>
			<a class="--go-back link tc-deep-blue" style="display: none;">< Go back</a>
			<div id="programs">
				<p class="label push-t-lrg">Which program are you most interested in?</p>
				<button class="button bg-deep-blue --choose-program --adults">Adults</button>
				<button class="button bg-white tc-deep-blue push-t-sml --choose-program --kids" style="border: 2px solid #0667D0;">Kids</button>
			</div>
			<div id="adults" class="--program" style="display: none;">
				<h2 class="title-wrapper">Adults Classes</h2>
				<p class="label">Choose the most convenient time</p>
				<form action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="program" value="adults">
					{if isset($adult_class_times) == false}
					<input class="question-choice-input" style="display: none;" id="default-question-1-adult" type="radio" name="schedule_time" value="today">
					<label for="default-question-1-adult" style="display: block;" class="question-choice --adult-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Today - Evening</label>
					<input class="question-choice-input" style="display: none;" id="default-question-2-adult" type="radio" name="schedule_time" value="tomorrow">
					<label for="default-question-2-adult" style="display: block;" class="question-choice --adult-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Tomorrow - Evening</label>
					<input class="question-choice-input" style="display: none;" id="default-question-3-adult" type="radio" name="schedule_time" value="days">
					<label for="default-question-3-adult" style="display: block;" class="question-choice --adult-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Within the next 3 days</label>
					<input class="question-choice-input" style="display: none;" id="default-question-3-adult" type="radio" name="schedule_time" value="later">
					<label for="default-question-3-adult" style="display: block;" class="question-choice --adult-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">3 or more days from today</label>
					{/if}
					<button type="submit" class="question-submit-adults button-link bg-deep-blue tc-white push-t-med" style="margin: 0 auto; margin-top: 25px; display: none;">Schedule Visit</button>
				</form>
			</div>
			<div id="kids" class="--program" style="display: none;">
				<h2 class="title-wrapper">Kids Classes</h2>
				<p class="label">Choose the most convenient time</p>
				<form action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="program" value="kids">
					{if isset($kids_class_times) == false}
					<input class="question-choice-input" style="display: none;" id="default-question-1-kid" type="radio" name="schedule_time" value="today">
					<label for="default-question-1-kid" style="display: block;" class="question-choice --kid-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Today - Afternoon</label>
					<input class="question-choice-input" style="display: none;" id="default-question-2-kid" type="radio" name="schedule_time" value="tomorrow">
					<label for="default-question-2-kid" style="display: block;" class="question-choice --kid-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Tomorrow - Afternoon</label>
					<input class="question-choice-input" style="display: none;" id="default-question-3-kid" type="radio" name="schedule_time" value="days">
					<label for="default-question-3-kid" style="display: block;" class="question-choice --kid-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">Within the next 3 days</label>
					<input class="question-choice-input" style="display: none;" id="default-question-3-kid" type="radio" name="schedule_time" value="later">
					<label for="default-question-3-kid" style="display: block;" class="question-choice --kid-question-choice mat-hov inner-pad-sml push-t-med cursor-pt h3">3 or more days from today</label>
					{/if}
					<button type="submit" class="question-submit-kids button-link bg-white tc-deep-blue push-t-med" style="margin: 0 auto; margin-top: 25px; display: none; border: 2px solid #0667D0;">Schedule Visit</button>
				</form>
			</div>
		</div>
	</div>
{/block}
