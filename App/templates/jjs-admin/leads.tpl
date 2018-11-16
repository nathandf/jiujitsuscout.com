{extends file="layouts/jjs-admin-core.tpl"}

{block name="jjs-admin-head"}{/block}

{block name="jjs-admin-body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med push-b-med">
		<table style="width: 100%;">
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Business</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Name</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Email</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Phone</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Source</th>
		{foreach from=$prospects item=prospect name="prospect_loop"}
			{if $smarty.foreach.prospect_loop.iteration <= 200}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="overflow: hidden; overflow: hidden; text-align: center; border: 1px solid #CCC;">{if isset($prospect->business_name)}{$prospect->business_name}{else}N/a{/if}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->getFullName()}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{if $prospect->email != "" || $prospect->phone->national_number != null}<i class="tc-good-green fa fa-check-square" aria-hidden="true"></i>{else}<i class="tc-red fa fa-close" aria-hidden="true"></i>{/if}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{if isset($prospect->phone)}{if $prospect->phone->national_number != "" || $prospect->phone->national_number != null}<i class="tc-good-green fa fa-check-square" aria-hidden="true"></i>{else}<i class="tc-red fa fa-close" aria-hidden="true"></i>{/if}{else}<i class="tc-red fa fa-close" aria-hidden="true">{/if}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->source}</td>
			<tr>
			{/if}
		{/foreach}
		</table>
	</div>
{/block}

{block name="jjs-admin-footer"}{/block}
