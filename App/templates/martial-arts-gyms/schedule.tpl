{extends file="layouts/core.tpl"}

{block name="head"}
	<script src="{$HOME}{$JS_SCRIPTS}self-schedule.js"></script>
{/block}

{block name="body"}
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
				<form action="">
					<button type="submit" class="button-link bg-deep-blue tc-white push-t-med" style="margin: 0 auto; margin-top: 25px;">Schedule Visit</button>
				</form>
			</div>
			<div id="kids" class="--program" style="display: none;">
				<h2 class="title-wrapper">Kids Classes</h2>
				<p class="label">Choose the most convenient time</p>
				<form action="">
					<button type="submit" class="button-link bg-white tc-deep-blue push-t-med" style="border: 2px solid #0667D0; margin: 0 auto; margin-top: 25px;">Schedule Visit</button>
				</form>
			</div>
		</div>
	</div>
{/block}
