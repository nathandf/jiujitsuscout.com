{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/user.css"/>
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		<div class="">
			<h2 class="h2">My Profile</h2>
			<table cellspacing="0" class="col-100 push-t-med push-b-med" style="border: 1px solid #CCC;">
				<tr class="bg-green">
					<th class="tc-white">Listing Clicks</td>
					<th class="tc-white">Leads</td>
				</tr>
				<tr class="bg-white">
					<td class="text-center">{$lisiting_clicks|@count}</td>
					<td class="text-center">--</td>
				</tr>
			</table>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
