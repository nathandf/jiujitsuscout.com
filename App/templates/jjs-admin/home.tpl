{extends file="layouts/core.tpl"}

{block name="head"}
	{include file="includes/head/main-head.tpl"}
{/block}

{block name="body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<table cellspacing="0" class="con-cnt-xxlrg push-t-med push-b-med">
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
{/block}

{block name="footer"}{/block}
