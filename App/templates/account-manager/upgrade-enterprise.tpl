{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
{include file="includes/head/account-manager-head.tpl"}
<script src="{$HOME}{$JS_SCRIPTS}upgrade.js"></script>
<link rel="stylesheet" type="text/css" href="{$HOME}public/css/upgrade.css"/>
{/block}

{block name="am-body"}
	{{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="con-cnt-xxlrg">
        <h2>Enterprise Upgrade</h2>
    </div>
{/block}
