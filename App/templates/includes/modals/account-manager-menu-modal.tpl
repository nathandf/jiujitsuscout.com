<div id="account-manager-menu-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-med-plus bg-white push-t-lrg" style="text-align: center;">
		<div class="inner-pad-sml">
			<h3>Menu</h3>
		</div>
		{if !is_null($user->getCurrentBusinessID())}
		<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
			<a class="link tc-deep-blue" href="{$HOME}account-manager/business/">Business Manager</a>
		</div>
		{/if}
		<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
			<a class="link tc-deep-blue" href="{$HOME}account-manager/">Account Overview</a>
		</div>
		<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
			<a class="link tc-deep-blue" href="{$HOME}account-manager/businesses">Businesses</a>
		</div>
		<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
			<a class="link tc-deep-blue" href="{$HOME}account-manager/settings/">Account Settings</a>
		</div>
		<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
			<a class="link tc-deep-blue" href="{$HOME}account-manager/logout">Logout</a>
		</div>
	</div>
</div>
