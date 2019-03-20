{extends file="layouts/core.tpl"}

{block name="body"}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con-cnt-med-plus-plus">
		<div class="inner-pad-med bg-white push-t-lrg push-b-lrg mat-box-shadow" style="border: 2px solid #CCCCCC;">
			<h2 class="title-wrapper">Thanks! We recieved your request and we'll get in touch with you ASAP!</h2>
			<div class="push-t-lrg"></div>
			<a class="button-link bg-good-green tc-white" style="display: block; margin: 0 auto;" href="{$HOME}martial-arts-gyms/{$business->id}/schedule-visit">Schedule your first free class</a>
		</div>
	</div>
{/block}
