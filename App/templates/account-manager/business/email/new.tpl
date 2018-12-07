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
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/emails/">< All Emails</a>
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
						<input type="text" name="name" value="{$inputs.create_email.name|default:null}" class="inp field-sml" placeholder="">
						<div class="clear push-t-med"></div>
						<p><b>Body:</b></p>
						<textarea name="body" value="{$inputs.create_email.body|default:null}" class="inp textarea" placeholder=""></textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Save Email">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
