{extends file="layouts/core.tpl"}

{block name="head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/ma-profile-main.css"/>
	{block name="business-profile-head"}{/block}
{/block}

{block name="body"}

	{include file="includes/widgets/questionnaire.tpl"}

	{include file='includes/navigation/main-menu.tpl'}
	<div class="con-cnt-xlrg push-t-med push-b-lrg bg-white" itemscope itemtype="http://schema.org/LocalBusiness">
		{*include file='includes/snippets/business-name.tpl'*}
		{*include file='includes/navigation/martial-arts-gym-nav.tpl'*}
		{block name="business-profile-body"}{/block}
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
