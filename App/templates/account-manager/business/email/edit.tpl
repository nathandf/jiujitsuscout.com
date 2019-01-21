{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/html-builder.css">
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery-src.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}email-builder.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	{include file="includes/widgets/insert-image-picker-email.tpl"}
	{include file="includes/widgets/insert-video-picker-email.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<div>
				<div class="clear"></div>
				<div class="con con-cnt-xlrg push-t-med inner-pad-med">
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/emails/">< All Emails</a>
					<div class="hr-sml"></div>
					<p class="text-sml">Create emails that you can use in automated marketing and follow up sequences. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/sequence/new">Create a sequence</a></p>
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
						<b>Body:</b>
						<p class="text-sml">Insert images and videos into your email. A placeholder tag will be used for all videos and images; They will be fully rendered when they are sent. Do not manipulate or adjust the tags in any way.</p>
						<div class="clear push-t-sml"></div>
						<button id="choose-insert-image" type="button" class="style-button cursor-pt"><i class="fa fa-picture-o" aria-hidden="true"></i></button>
						<button id="choose-insert-video" type="button" class="style-button cursor-pt"><i class="fa fa-video-camera" aria-hidden="true"></i></button>
						<div class="clear push-t-sml"></div>
						<textarea name="body" id="email-body" class="inp textarea-tall" placeholder="">{$email->body}</textarea>
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
