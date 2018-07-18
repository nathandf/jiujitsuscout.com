{extends file="layouts/jjs-admin-core.tpl"}

{block name="jjs-admin-head"}{/block}

{block name="jjs-admin-body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med push-b-med">
		<table style="width: 100%;">
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC; width: 50px;">#</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Business</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Name</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Email</th>
			<th class="bg-salmon tc-white" style="border: 1px solid #CCC;">Phone Number</th>
		{foreach from=$prospects item=prospect name="prospect_loop"}
			{if $smarty.foreach.prospect_loop.iteration <= 100}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC; width: 50px">{$smarty.foreach.prospect_loop.iteration}</td>
				<td style="overflow: hidden; overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->business_name}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->first_name}{if isset($prospect->last_name)} {$prospect->last_name}{/if}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$prospect->email}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">+{$prospect->phone->country_code} {$prospect->phone->national_number}</td>
			<tr>
			{/if}
		{/foreach}
		</table>
	</div>
{/block}

{block name="jjs-admin-footer"}{/block}
