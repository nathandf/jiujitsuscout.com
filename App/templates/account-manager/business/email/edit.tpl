{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<div>
				<div class="clear"></div>
				<div class="con con-cnt-xlrg push-t-med inner-pad-med">
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/emails/">< All Emails</a>
					<div class="hr-sml"></div>
					<p class="text-sml">Create emails that you can use in automated email marketing and follow up sequences</p>
					{if !empty($error_messages.update_email)}
						{foreach from=$error_messages.update_email item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					{include file="includes/snippets/flash-messages.tpl"}
					<form method="post" action="{$HOME}account-manager/business/email/{$email->id}/edit">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="update_email" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<p><b>Subject:</b></p>
						<input style="padding: 3px;" type="text" name="subject" value="{$email->subject}" class="inp" placeholder="">
						<div class="clear push-t-med"></div>
						<p><b>Body:</b></p>
						<textarea name="body" class="inp textarea" placeholder="">{$email->body}</textarea>
						<div class="clear"></div>
						<div class="hr-sml"></div>
						<p class="text-sml">Add a name and description to help you identify the purpose of this email</p>
						<p class="push-t-med"><b>Name:</b></p>
						<input style="padding: 3px;" type="text" name="name" value="{$email->name}" class="inp" placeholder="">
						<div class="clear push-t-med"></div>
						<p><b>Description:</b></p>
						<textarea name="description" class="inp textarea" placeholder="">{$email->description}</textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Update Email">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
