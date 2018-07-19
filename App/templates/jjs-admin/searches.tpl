{extends file="layouts/jjs-admin-core.tpl"}

{block name="jjs-admin-head"}{/block}

{block name="jjs-admin-body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med push-b-med">
		<table style="width: 100%;">
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC; border: 1px solid #CCC; width: 50px;">#</th>
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC; border: 1px solid #CCC;">Query</th>
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC;">Time</th>
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC;">Results</th>
		{foreach from=$searches item=search name="business_loop"}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$smarty.foreach.business_loop.iteration}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$search->query}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$search->time|date_format:"%A, %b %e %Y"} {$search->time|date_format:"%l:%M%p"}</td>
				<td style="overflow: hidden; text-align: center; border: 1px solid #CCC;">{$search->result->business_ids}</td>
			<tr>
		{/foreach}
		</table>
	</div>
{/block}

{block name="jjs-admin-footer"}{/block}
