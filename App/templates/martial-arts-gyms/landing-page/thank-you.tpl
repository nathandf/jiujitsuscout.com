{extends file="layouts/core.tpl"}

{block name="body"}
	<div class="con-cnt-xxlrg">
		<div class="inner-pad-med bg-white push-t-lrg push-b-lrg mat-box-shadow" style="border: 2px solid #CCCCCC;">
			<h2 class="title-wrapper">Thanks! We recieved your request and we'll get in touch with you ASAP!</h2>
			<p class="text-xlrg-heavy" style="text-align: center; max-width: 50ch; margin: 0 auto;">In the meantime, learn more about our gym by visiting our profile.</p>
			<div class="con-cnt-fit push-b-lrg">
				<i class="fa fa-4x fa-check-square tc-good-green push-t-med" aria-hidden="true"></i>
			</div>
			<a class="btn button-med bg-deep-blue tc-white push-t-med" style="display: block; margin: 0 auto;" href="{$HOME}martial-arts-gyms/{$business->id}/">View Profile</a>
		</div>
	</div>
{/block}
