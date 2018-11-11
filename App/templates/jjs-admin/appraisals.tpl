{extends file="layouts/jjs-admin-core.tpl"}

{block name="jjs-admin-head"}{/block}

{block name="jjs-admin-body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med push-b-med">
		<table style="width: 100%;">
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Name</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Appraisal</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Purchased</th>
		{foreach from=$prospectAppraisals item=prospectAppraisal name="prospect_loop"}
			{if $smarty.foreach.prospect_loop.iteration <= 100}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="overflow: hidden; overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospectAppraisal->prospect->getFullName()}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">${$prospectAppraisal->value}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{if $prospectAppraisal->purchase->id != null}Yes{else}No{/if}</td>
			<tr>
			{/if}
		{/foreach}
		</table>
	</div>
{/block}

{block name="jjs-admin-footer"}{/block}
