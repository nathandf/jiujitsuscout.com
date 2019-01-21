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
			<h2 class="">Forms</h2>
			<p class="text-sml">Create embeddable forms to capture leads with external lead generation sources</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/form/new" class="btn btn-inline mat-hov push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">Create a Form</span></a>
			<div class="clear push-b-med"></div>
			{foreach from=$forms item=form}
			<a href="{$HOME}account-manager/business/form/{$form->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-red tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-file-text-o"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$form->name}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{foreachelse}
			<p>You haven't made any forms yet</p>
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}
