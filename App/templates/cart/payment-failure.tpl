{extends file="layouts/core.tpl"}

{block name="head"}
	{include file='includes/head/main-head.tpl'}

{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="con-cnt-xxlrg">
		<div class="inner-pad-med">
			<h2 class="title-wrapper">There was an issure with your payment.</h2>
			<div class="con-cnt-fit">
				<i class="fa fa-4x fa-window-close tc-error" aria-hidden="true"></i>
			</div>
		</div>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
