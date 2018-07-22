{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg">
		<table cellspacing="0" style="width: 100%; border: 1px solid #CCC;" class="push-t-med push-b-med">
			<tr class="bg-green">
				<th class="tc-white">Accounts</td>
				<th class="tc-white">Users</td>
				<th class="tc-white">Businesses</td>
				<th class="tc-white">Prospects</td>
				<th class="tc-white">Searches</td>
			</tr>
			<tr class="bg-white">
				<td class="text-center">{$accounts|@count}</td>
				<td class="text-center">{$users|@count}</td>
				<td class="text-center">{$businesses|@count}</td>
				<td class="text-center">{$prospects|@count}</td>
				<td class="text-center">{$searches|@count}</td>
			</tr>
		</table>
		<h2>No Result Sign Ups</h2>
		<table class="push-t-med push-b-med" style="width: 100%; border: 1px solid #CCC;">
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Name</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Email</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Phone Number</th>
		{foreach from=$noResultProspects item=prospect name="no_result_prospect_loop"}
			{if $smarty.foreach.no_result_prospect_loop.iteration <= 100}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->first_name}{if isset($prospect->last_name)} {$prospect->last_name}{/if}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->email}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">+{$prospect->phone->country_code} {$prospect->phone->national_number}</td>
			<tr>
			{/if}
		{/foreach}
		</table>
	</div>
{/block}

{block name="footer"}{/block}
