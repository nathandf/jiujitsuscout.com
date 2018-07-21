{extends file="layouts/core.tpl"}

{block name="head"}
  {include file="includes/head/account-manager-head.tpl"}
  <link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css">
  {block name="marketing-manager-head"}{/block}
{/block}
{block name="body"}
  {include file="includes/navigation/business-manager-login-menu.tpl"}
  {include file="includes/navigation/business-manager-marketing-menu.tpl"}
  {block name="marketing-manager-body"}{/block}
{/block}
