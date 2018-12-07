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
					<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/sequences/">< All Sequences</a>
					{if !empty($error_messages.create_sequence)}
						{foreach from=$error_messages.create_sequence item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form method="post" action="{$HOME}account-manager/business/sequence/new">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="create_sequence" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<p><b>Sequence Name:</b></p>
						<input type="text" name="name" value="{$inputs.create_sequence.name|default:null}" class="inp field-sml" placeholder="">
						<div class="clear push-t-med"></div>
						<p><b>Description:</b></p>
						<textarea name="offer" value="{$inputs.create_sequence.offer|default:null}" class="inp textarea" placeholder=""></textarea>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline" value="Create Sequence">
					</form>
				</div>
			</div><!-- end content -->
		</div>
	</div>
{/block}
