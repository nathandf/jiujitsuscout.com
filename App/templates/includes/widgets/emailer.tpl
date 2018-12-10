<div id="emailer" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-lrg bg-white inner-pad-med push-t-lrg">
		<h2 class="push-b-med">Send Email</h2>
		{if isset($emailerHelper)}
			{if $emailerHelper->ready()}
				<table class="table">
					<tr style="border: 1px solid #CCC;">
						<td style="text-align: center;" class="bg-mango tc-white inner-pad-xsml"><p class="text-med-heavy">From:</p></td>
						<td><p class="text-med inner-pad-xsml">{$emailerHelper->sender_name} @ {$emailerHelper->sender_email}</p></td>
					</tr>
					<tr style="border: 1px solid #CCC;">
						<td style="text-align: center;" class="bg-mango tc-white inner-pad-xsml"><p class="text-med-heavy">To:</p></td>
						<td><p class="text-med inner-pad-xsml">{$emailerHelper->recipient_name} @ {$emailerHelper->recipient_email}</p></td>
					</tr>
				</table>
				<div class="clear push-t-med"></div>
				<form method="post" action="">
					<input type="hidden" name="send_email" value="{$csrf_token}">
					<input type="hidden" name="token" value="{$csrf_token}">
					<label class="text-med-heavy" for="">Subject:</label>
					<div class="clear"></div>
					<input class="inp" name="subject" required="required">
					<div class="clear push-t-sml"></div>
					<label class="text-med-heavy" for="">Body:</label>
					<div class="clear"></div>
					<textarea class="inp textarea" name="body" required="required"></textarea>
					<div class="clear"></div>
					<button type="submit" class="btn btn-inline push-t-sml"><span class="push-r-sml">Send Email</span><i class="fa fa-envelope-o" aria-hidden="true"></i><button>
					<div class="clear"></div>
				</form>
			{else}
				{foreach from=$emailerHelper->getErrorMessages() item=message}
				<p>{$message}</p><br>
				{/foreach}
			{/if}
		{else}
		<p>Emailer Unavailable</p>
		{/if}
	</div>
</div>
