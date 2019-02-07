<script>
	$( function () {
		// Primary Image Picker Widget
		$( ".primary-video-picker-video" ).on( "click", function () {
			$( "#primary_video_id" ).val( this.dataset.id );
			$( "#primary_video_picker_form" ).submit();
			$( "#primary-video-picker-modal" ).hide();
		} );

		$( "#choose-primary-video" ).on( "click", function () {
			$( "#primary-video-picker-modal" ).show();
		} );

		$( "#primary-video-picker-close" ).on( "click", function () {
			$( "#primary-video-picker-modal" ).hide();
		} );
	} );
</script>
<form id="primary_video_picker_form" action="" method="post">
	<input type="hidden" name="token" value="{$csrf_token}">
	<input id="primary_video_id" type="hidden" name="video_id" value="">
</form>
<div id="primary-video-picker-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p id="primary-video-picker-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med border-std">
		{foreach from=$videos item="_video"}
			<div class="clear push-t-sml"></div>
			<div>
				{if isset($_video->filename) && isset($_video->type)}
				<p class="text-lrg-heavy">{$_video->name}</p>
				<p class="text-sml">{$_video->description}</p>
				<video style="border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;" controls>
				  <source src="{$HOME}public/videos/{$_video->filename}" type="{$_video->type}">
				  Your browser does not support the video tag.
				</video>
				{/if}
				<div class="clear"></div>
				<button class="btn btn-inline primary-video-picker-video video-picker-video push-t-med" data-id="{$_video->id}">Make Primary Video</button>
			</div>
			<div class="hr-sml push-t-sml"></div>
		{foreachelse}
			<p>No Videos Uploaded Yet</p>
		{/foreach}
	</div>
</div>
