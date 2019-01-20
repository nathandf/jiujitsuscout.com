{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
	<link rel="stylesheet" href="{$HOME}public/css/article-builder.css">
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery-src.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}rangyinputs-jquery.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}html-builder.js"></script>
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
					{if !empty($error_messages.create_email)}
						{foreach from=$error_messages.create_email item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form method="post" action="{$HOME}account-manager/business/email/new">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="create_email" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<p><b>Subject:</b></p>
						<input style="padding: 3px;" type="text" name="subject" value="{$inputs.create_email.name|default:null}" class="inp" placeholder="">
						<div class="clear push-t-med"></div>
						<b>Body:</b>
						<div class="clear push-t-sml"></div>
						<button id="choose-insert-image" type="button" class="style-button cursor-pt"><i class="fa fa-picture-o" aria-hidden="true"></i></button>
						<button id="choose-insert-video" type="button" class="style-button cursor-pt"><i class="fa fa-video-camera" aria-hidden="true"></i></button>
						<div class="clear push-t-sml"></div>
						{include file="includes/widgets/anchor-widget.tpl"}
						<textarea id="article-body" name="body" class="inp textarea-tall" placeholder="">{$inputs.create_email.body|default:null}</textarea>
						<div class="clear"></div>
						<div class="hr-sml"></div>
						<p class="text-sml">Add a name and description to help you identify the purpose of this email</p>
						<p class="push-t-med"><b>Name:</b></p>
						<input style="padding: 3px;" type="text" name="name" value="{$inputs.create_email.description|default:null}" class="inp" placeholder="">
						<div class="clear push-t-med"></div>
						<p ><b>Description:</b></p>
						<textarea name="description" class="inp textarea" placeholder="">{$inputs.create_email.description|default:null}</textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Save Email">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
