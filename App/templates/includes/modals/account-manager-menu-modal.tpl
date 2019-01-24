<div id="account-manager-menu-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-med-plus bg-white push-t-lrg" style="text-align: center;">
		<div class="inner-pad-sml tc-white bg-deep-blue">
			<h3>Menu</h3>
		</div>
		<a class="link tc-deep-blue text-med-heavy" href="{$HOME}account-manager/">
			<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
				<p>Account Overview</p>
			</div>
		</a>
		{if !is_null($user->getCurrentBusinessID())}
		<a class="link tc-deep-blue text-med-heavy" href="{$HOME}account-manager/business/">
			<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
				<p>Business Manager</p>
			</div>
		</a>
		{/if}
		<a class="link tc-deep-blue text-med-heavy" href="{$HOME}account-manager/settings/">
			<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
				<p>Settings</p>
			</div>
		</a>
		<a class="link tc-deep-blue text-med-heavy" href="{$HOME}account-manager/logout">
			<div class="col-100 inner-pad-sml" style="border-top: 1px solid #CCC;">
				<p>Logout</p>
			</div>
		</a>
	</div>
</div>
