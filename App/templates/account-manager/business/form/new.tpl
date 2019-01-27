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
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/forms/">< All Forms</a>
					{if !empty($error_messages.create_form)}
						{foreach from=$error_messages.create_form item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form method="post" action="{$HOME}account-manager/business/form/new">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="create_form" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<p><b>Form Name:</b></p>
						<input type="text" name="name" value="{$inputs.create_form.name|default:null}" class="inp inp-med-plus-plus" placeholder="Form name">
						<div class="clear push-t-med"></div>
						<p><b>Offer:</b></p>
						<p class="text-sml">What are you offering in exchange for filling out this form?</p>
						<textarea name="offer" value="{$inputs.create_form.offer|default:null}" class="inp textarea" placeholder="Ex. Try a class for free!"></textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Build Form">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
