{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/sequence.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Sequences</h2>
			<p class="text-sml">Create automated follow up sequences for your leads and students</p>
			<div class="hr-sml"></div>
			<a href="{$HOME}account-manager/business/sequence/new" class="btn btn-inline mat-hov push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">Create a Sequence</span></a>
			<div class="clear push-b-sml"></div>
			{foreach from=$sequences item=sequence}
			<a style="text-decoration: none; color: #000;" href="{$HOME}account-manager/business/sequence/{$sequence->id}/">
				<div class="sequence-tag mat-hov cursor-pt">
					<div class="bg-salmon tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-sitemap"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$sequence->name}</p>
						<p class="text-med" style="max-width: 80ch;">{$sequence->description}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-t-med"></div>
			{foreachelse}
			-- No sequences have been create yet --
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}
