{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Landing Pages</h2>
			<p class="text-sml">Capture leads with landing pages! The JiuJitsuScout Landing Page builder makes it super easy to build effective landing pages that drive action and capture leads.</p>
			<div class="hr-sml"></div>
			<a href="{$HOME}account-manager/business/landing-page/choose-template" class="btn btn-inline push-t-med mat-hov"><span class="text-med">Create Landing Page <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear push-t-med"></div>
			{foreach from=$pages item=page}
			<a href="{$HOME}account-manager/business/landing-page/{$page->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-deep-blue tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-globe"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$page->name}</p>
						<p class="text-med" style="max-width: 80ch;">{$page->slug}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}
