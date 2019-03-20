{extends file="layouts/business-profile.tpl"}

{block name="business-profile-body"}
	<div class="con-cnt-med-plus-plus push-t-med inner-pad-med">
		<h2>Registration Complete <i class="fa fa-check-square tc-good-green" aria-hidden="true"></i></h2>
		<p class="push-t-med">A staff member of {$business->business_name} will contact you shortly to schedule your first free class.</p>
		<div class="push-t-lrg"></div>
		<a class="button-link bg-good-green tc-white" style="display: block; margin: 0 auto;" href="{$HOME}martial-arts-gyms/{$business->id}/schedule-visit">Schedule your first free class</a>
		<div class="push-t-lrg"></div>
		{if $faqAnswers|@count > 0}
			<h3 class="push-t-lrg">Frequently Asked Questions</h3>
			<div class="hr-sml"></div>
			<table class="push-t-med">
				{foreach from=$faqAnswers item=faqAnswer}
				<tr class="push-t-med">
					<td style="vertical-align: top;">
						<p class="text-lrg-heavy push-r">Q:</p>
					</td>
					<td>
						<p class="text-lrg-heavy">{$faqAnswer->faq->text}</p>
					</td>
				</tr>
				<tr>
					<td style="vertical-align: top;">
						<p class="text-lrg push-r">A:</p>
					</td>
					<td>
						<p class="text-lrg">{$faqAnswer->text}</p>
					</td>
				<tr>
				{/foreach}
			</table>
		{/if}
	</div>
	<div class="clear"></div>
{/block}
