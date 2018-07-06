{extends file="layouts/landing-page-core.tpl"}

{block name="lp-head"}
<!-- lp-head -->
{$page->facebook_pixel|default:""}
<!-- lp-head-end -->
{/block}

{block name="lp-body"}
	<div class="main-content">
		{if $page->headline}<p id="headline" class="title">{$page->headline}</span></p>{/if}
		{if $page->image_a}
		<img id="image_a" class="pic" src="{$HOME}img/uploads/{$page->image_a}">
		{/if}
		{if $page->text_a}
		<div class="section">
			<p id="text_a" class="sub-title">{$page->text_a}</p>
		</div>
		{/if}
		<div class="section">
			{include file="includes/forms/standard-form.tpl"}
		</div>
		{if $page->text_b}
		<div class="section">
			<p id="text_b" class="sub-title">{$page->text_b}</p>
		</div>
		{/if}
		{if $page->image_b}
		<img id="image_b" class="pic" src="{$HOME}img/uploads/{$page->image_b}">
		{/if}
		{if $page->text_c}<p id="text_c" class="sub-title">{$page->text_c}</p>{/if}
		{if $page->image_c}
		<img id="image_c" class="pic" src="{$HOME}img/uploads/{$page->image_c}">
		{/if}
		<div class="section">
			<button type="submit" class="cta-button" name="apply">{$page->call_to_action|default:"Reserve your spot"}</button>
			<p class="sub-cta-text"><i class="fa fa-clock" aria-hidden="true"></i> <strong>P.S.</strong> Only 30 Spots Available. Offer Ends In <span class="alert-text">6</span> Days</p>
		</div>
	</div>
{/block}
