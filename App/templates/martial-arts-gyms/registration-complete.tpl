{extends file="layouts/business-profile.tpl"}

{block name="business-profile-body"}
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<h2>Registration Complete <i class="fa fa-check-square tc-good-green" aria-hidden="true"></i></h2>
		<p class="push-t-med">A staff member of {$business->business_name} will contact you shortly to schedule your first free class.{if $faqAnswers|@count > 0} In the meantime, checkout out some of the frequently asked questions for this gym.{/if}</p>
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
