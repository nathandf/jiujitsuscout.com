{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/user.css"/>
	<link rel="stylesheet" href="{$HOME}/public/css/business-profile.css">
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/profile-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-pad-med push-t-med">
		{if !$business->profile_complete}
			<div class="col-100 bg-white mat-box-shadow push-b-med" style="border-radius: 3px;">
				<div class="onboarding-message bg-deep-blue">
					<p class="text-lrg-heavy">Profile Completion: {$profile_completion_percentage}%</p>
					<p class="text-med push-t-sml">Show your profile visitors what makes your business unique!</p>
				</div>
				<div class="inner-pad-med">
					<p class="text-sml push-b-sml"><span class="text-sml-heavy tc-red">IMPORTANT: </span>Only the address is needed for your business to show up in the search listings, however, incomplete profiles rarely generate leads.</p>
					<table style="table-layout: auto;">
						<tr>
							<td>
								{if !is_null($business->logo_image_id)}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/profile/logo">Add your logo</a>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								{if $business_location_added}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/settings/location">Add your business's address</a>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								{if !is_null($business->message)}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/profile/message">Tell your profile visitors about your business</a>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								{if $faqs_answered}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/profile/faqs">Answer some frequently asked questions</a>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								{if $images|@count > 0}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/profile/images">Upload some images of your business</a>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								{if !is_null($business->video_id)}
								<i class="fa fa-check tc-good-green push-r-sml" aria-hidden="true"></i>
								{else}
								<i class="fa fa-close tc-red push-r-sml" aria-hidden="true"></i>
								{/if}
							</td>
							<td>
								<p class="text-lrg">
									<a class="link tc-deep-blue" href="{$HOME}account-manager/business/profile/video">Upload a video of your business in action!</a>
								</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		{/if}
		<div>
			<h2 class="h2">Lead Generation Profile</h2>
			<table cellspacing="0" class="col-100 push-t-med push-b-med" style="border: 1px solid #CCC;">
				<tr class="bg-green">
					<th class="tc-white">Listing Clicks</td>
					<th class="tc-white">Leads</td>
				</tr>
				<tr class="bg-white">
					<td class="text-center">{$lisiting_clicks|@count}</td>
					<td class="text-center">--</td>
				</tr>
			</table>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
