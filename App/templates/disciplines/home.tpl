{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Martial Arts Disiplines List | Brazilian Jiu Jitsu, MMA, and more</title>
	<meta name="description" content="Choose the martial art your interested in and connect with the gyms in your area. Try a class for free with any gym on JiuJitsuScout.">
{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="alt-content">
		<div class="con-cnt-xxlrg inner-pad-med">
			<h2 style="color: #2F3033;" class="push-b-lrg">Choose a discipline</h2>
			{foreach from=$disciplines item=discipline name=discipline_loop}
				<div class="discipline-container cursor-pt" style="box-sizing: border-box; padding: 5px; width: 25%; min-width: 150px; float: left;">
					<a href="{$HOME}disciplines/{$discipline->url}/near-me/" class="text-lrg-heavy link" style="color: #2F3033;">> {$discipline->nice_name}</a>
					<div class="clear push-b-sml"></div>
				</div>
				{if $smarty.foreach.discipline_loop.iteration % 4 == 0}
				<div class="clear"></div>
				{/if}
			{/foreach}
			<div class="clear"></div>
		</div>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
