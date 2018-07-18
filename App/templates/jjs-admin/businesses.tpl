{extends file="layouts/jjs-admin-core.tpl"}

{block name="jjs-admin-head"}{/block}

{block name="jjs-admin-body"}
	{include file="includes/navigation/admin-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med push-b-med">
		<table style="width: 100%;">
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC;">Business</th>
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC;">Email</th>
			<th class="bg-dark-mint tc-white" style="border: 1px solid #CCC;">Phone Number</th>
		{foreach from=$businesses item=business}
			<tr style="background: {cycle values='#FFF,#F6F7F9'}">
				<td style="text-align: center; border: 1px solid #CCC;">{$business->business_name}</td>
				<td style="text-align: center; border: 1px solid #CCC;">{$business->email}</td>
				<td style="text-align: center; border: 1px solid #CCC;">+{$business->phone->country_code} {$business->phone->national_number}</td>
			<tr>
		{/foreach}
		</table>
	</div>
{/block}

{block name="jjs-admin-footer"}{/block}
