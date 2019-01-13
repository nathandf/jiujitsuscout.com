{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/sequence.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xxlrg push-t-med inner-pad-med">
			<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/leads">Leads</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/lead/{$lead->id}/">{$lead->getFullName()}</a> > Add to Sequence</p>
			<h2 class="push-t-med">Choose a sequence</h2>
			<p class="text-sml">Add {$lead->getFullName()} to a follow up sequence.</p>
			<div class="hr-sml"></div>
			{if !empty($error_messages.add_to_sequence)}
				{foreach from=$error_messages.add_to_sequence item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<div class="clear push-t-med"></div>
			{foreach from=$inactiveSequenceTemplates item=sequence}
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_to_sequence" value="{$csrf_token}">
				<input type="hidden" name="sequence_template_id" value="{$sequence->id}">
				<button type="submit" style="width: 100%; text-decoration: none; color: #000;">
					<div class="sequence-tag mat-hov cursor-pt">
						<p class="text-med-heavy">{$sequence->name}</p>
						<p class="text-med">{$sequence->description}</p>
					</div>
				</button>
			</form>

			<div class="clear push-t-med"></div>
			{foreachelse}
			{if !empty( $activeSequenceTemplates )}
				-- All sequences are currently in use --
			{else}
				-- No sequences available --
				<div class="clear push-t-med"></div>
				<a class="btn btn-inline bg-deep-blue text-med-heavy" href="{$HOME}account-manager/business/sequence/new">Create a Sequence Template +</a>
			{/if}
			{/foreach}
			{if !empty( $activeSequenceTemplates )}
				<div class="clear push-t-med"></div>
				<h2>Active Sequences</h2>
				<p class="text-sml">{$lead->getFullName()} is already on these sequences</p>
				{foreach from=$activeSequenceTemplates item=sequence}
				<div class="sequence-tag push-t-med" style="text-align: center;">
					<p class="text-med-heavy">{$sequence->name}</p>
					<p class="text-med">{$sequence->description}</p>
				</div>
				{/foreach}
			<div class="clear push-t-med"></div>
			{/if}
		</div>
	</div><!-- end content -->
{/block}
