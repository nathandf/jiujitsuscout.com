{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	{block name="bm-head"}{/block}
{/block}

{block name="am-body"}
	{include file="includes/navigation/business-manager-login-menu.tpl"}
	{include file="includes/navigation/business-manager-main-menu.tpl"}
	{block name="bm-body"}
	{/block}
{/block}
