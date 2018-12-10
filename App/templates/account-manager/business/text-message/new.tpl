{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<div>
				<div class="clear"></div>
				<div class="con con-cnt-xlrg push-t-med inner-pad-med">
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/text-messages/">< All Text Messages</a>
					<div class="hr-sml"></div>
					<p class="text-sml">Create text messages that you can use in automated marketing and follow up sequences</p>
					{if !empty($error_messages.create_text_message)}
						{foreach from=$error_messages.create_text_message item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form method="post" action="{$HOME}account-manager/business/text-message/new">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="create_text_message" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<p><b>Message:</b></p>
						<textarea name="body" class="inp textarea" placeholder="">{$inputs.create_text_message.body|default:null}</textarea>
						<div class="clear"></div>
						<div class="hr-sml"></div>
						<p class="text-sml">Add a name and description to help you identify the purpose of this text message</p>
						<p class="push-t-med"><b>Name:</b></p>
						<input style="padding: 3px;" type="text" name="name" value="{$inputs.create_text_message.description|default:null}" class="inp" placeholder="">
						<div class="clear push-t-med"></div>
						<p ><b>Description:</b></p>
						<textarea name="description" class="inp textarea" placeholder="">{$inputs.create_text_message.description|default:null}</textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Save Text Message">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
