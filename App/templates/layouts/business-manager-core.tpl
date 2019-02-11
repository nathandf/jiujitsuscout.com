{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<script src="{$HOME}{$JS_SCRIPTS}business-manager-main.js"></script>
	{block name="bm-head"}{/block}
{/block}

{block name="am-body"}
	{include file="includes/navigation/business-manager-login-menu.tpl"}
	{include file="includes/navigation/business-manager-main-menu.tpl"}
	{block name="bm-body"}
	{/block}
	<div class="clear push-t-xlrg"></div>
	<!-- <div class="action-button-container">
		<button class="button-action bg-deep-blue tc-white cursor-pt mat-hov floatright push-r-med">
			<i class="fa fa-2x fa-search" aria-hidden="true"></i>
		</button>
		<button class="button-action bg-salmon tc-white cursor-pt mat-hov floatright push-r-med">
			<i class="fa fa-2x fa-plus" aria-hidden="true"></i>
		</button>
		<button class="button-action bg-lavender tc-white cursor-pt mat-hov floatright push-r-med">
			<i class="fa fa-2x fa-question" aria-hidden="true"></i>
		</button>
		<button class="button-action bg-real-gold tc-white cursor-pt mat-hov floatright push-r-med">
			<i class="fa fa-2x fa-trophy" aria-hidden="true"></i>
		</button>
	</div> -->
{/block}
