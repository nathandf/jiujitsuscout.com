<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}sms-convo-box.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-med-plus-plus push-t-med push-b-lrg bg-white mat-box-shadow" style="border-radius: 5px; border: 2px solid #DDD;">
			<div class="col-100 inner-pad-med" style="border-bottom: 2px solid #DDD;">
				<h2 style="weight: 100; text-align: center;">New Lead</h2>
			</div>
			<div class="inner-pad-med">
				<h3 class="push-b-med" style="text-align: center;">Contact Information</h3>
				<table style="margin: 0 auto;">
					<tr>
						<td><p class="text-med push-r-med">Name:</p></td>
						<td>{if isset($lead->first_name) && $lead->email != ""}Available <i class="tc-good-green fa fa-check-square" aria-hidden="true"></i>{else}Unavailable <i class="tc-red fa fa-close" aria-hidden="true"></i>{/if}</td>
					</tr>
					<tr>
						<td><p class="text-med push-r-med">Email:</p></td>
						<td>{if isset($lead->email) && $lead->email != ""}Available <i class="tc-good-green fa fa-check-square" aria-hidden="true"></i>{else}Unavailable <i class="tc-red fa fa-close" aria-hidden="true"></i>{/if}</td>
					</tr>
					<tr>
						<td><p class="text-med push-r-med">Phone<br>Number: </p></td>
						<td>{if isset($lead->phone_number) && $lead->phone_number != ""}Available <i class="tc-good-green fa fa-check-square" aria-hidden="true"></i>{else}Unavailable <i class="tc-red fa fa-close" aria-hidden="true"></i>{/if}</td>
					</tr>
				</table>
				<div class="col-100 push-t-med" style="border-top: 1px solid #CCC;"></div>
				<h3 class="push-t-med push-b-med" style="text-align: center;"><span style="text-align: center;" class="text-med">Total: </span>{$business->currency->symbol}{$lead->appraisal->value|string_format:"%.2f"}</h3>
				{if $account->credit >= $lead->appraisal->value}
				<form method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="purchase" value="{$csrf_token}">
					<button class="btn btn-cnt bg-gold tc-black text-med-heavy cursor-pt mat-hov --c-purchase" style="margin-bottom: 0px; box-sizing: border-box; border: 2px solid #333; border-radius: 55px; width: 80%; height: 55px; text-align: center;">Buy Now</button>
				</form>
				{else}
				<a href="{$HOME}account-manager/add-credit" class="btn btn-cnt bg-good-green tc-white text-med-heavy cursor-pt mat-hov push-t-med" style="margin-bottom: 0px; box-sizing: border-box; border: none; border-radius: 55px; width: 80%; height: 55px; text-align: center; line-height: 38px;">Fund account</a>
				{/if}
				<table style="margin: 0 auto;">
					<tr>
						<td><p class="text-sml push-r">Available Credit:</p></td>
						<td><p class="text-sml-heavy">{$business->currency->symbol}{$account->credit|string_format:"%.2f"}</p>
					</tr>
				</table>
				<form method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="reject" value="true">
					<button class="tc-salmon cursor-pt text-med-heavy link --c-reject-prospect" style="display: block; margin: 0 auto; margin-top: 20px; background: none;">Reject this lead</button>
				</form>
				{if isset($respondent->questionAnswers) && $respondent->questionAnswers|count > 0}
					<div class="col-100 push-t-med" style="border-top: 1px solid #CCC;"></div>
					<h3 class="push-t-med">Questionnaire Details</h3>
					{foreach from=$respondent->questionAnswers item=questionAnswer}
						<p class="text-lrg-heavy push-t-med">Q: {$questionAnswer->question->text}</p>
						<p class="text-lrg push-t">A: <i>{$questionAnswer->questionChoice->text}{if isset($questionAnswer->text) && $questionAnswer->text != ""} | {$questionAnswer->text}{/if}</i></p>
					{/foreach}
					<div class="col-100 push-t-med" style="border-top: 1px solid #CCC;"></div>
					<h3 class="push-t-med push-b-med" style="text-align: center;"><span style="text-align: center;" class="text-med">Total: </span>{$business->currency->symbol}{$lead->appraisal->value|string_format:"%.2f"}</h3>
					{if $account->credit >= $lead->appraisal->value}
					<form method="post" action="">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="purchase" value="{$csrf_token}">
						<button class="btn btn-cnt bg-gold tc-black text-med-heavy cursor-pt mat-hov --c-purchase" style="margin-bottom: 0px; box-sizing: border-box; border: 2px solid #333; border-radius: 55px; width: 80%; height: 55px; text-align: center;">Buy Now</button>
					</form>
					{else}
					<a href="{$HOME}account-manager/add-credit" class="btn btn-cnt bg-good-green tc-white text-med-heavy cursor-pt mat-hov push-t-med" style="margin-bottom: 0px; box-sizing: border-box; border: none; border-radius: 55px; width: 80%; height: 55px; text-align: center; line-height: 38px;">Fund account</a>
					{/if}
					<table style="margin: 0 auto;">
						<tr>
							<td><p class="text-sml push-r">Available Credit:</p></td>
							<td><p class="text-sml-heavy">{$business->currency->symbol}{$account->credit|string_format:"%.2f"}</p>
						</tr>
					</table>
					<form method="post" action="">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="reject" value="true">
						<button class="tc-salmon cursor-pt text-med-heavy link --c-reject-prospect" style="display: block; margin: 0 auto; margin-top: 20px; background: none;">Reject this lead</button>
					</form>
				{/if}
			</div>
		</div>
	</body>
</html>
