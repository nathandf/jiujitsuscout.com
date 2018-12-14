{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/sequence.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Sequences</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/sequence/new" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Create a Sequence <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<p class="text-sml push-b-med">Create automated follow up sequences for your leads and students</p>
			{foreach from=$sequences item=sequence}
			<a style="text-decoration: none; color: #000;" href="{$HOME}account-manager/business/sequence/{$sequence->id}/" class="">
				<div class="sequence-tag mat-hov cursor-pt">
					<p class="text-med-heavy">{$sequence->name}</p>
					<p class="text-med">{$sequence->description}</p>
				</div>

			</a>
			{foreachelse}
			-- No sequences have been create yet --
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}
