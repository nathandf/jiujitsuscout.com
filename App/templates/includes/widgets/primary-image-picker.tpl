<script>
	$( function () {
		// Primary Image Picker Widget
		$( ".primary-image-picker-image" ).on( "click", function () {
			$( "#primary_image_id" ).val( this.dataset.id );
			$( "#primary_image_display" ).attr( "src", $( this ).attr( "src" ) );
			$( "#primary-image-picker-modal" ).hide();
		} );

		$( "#choose-primary-image" ).on( "click", function () {
			$( "#primary-image-picker-modal" ).show();
		} );

		$( "#primary-image-picker-close" ).on( "click", function () {
			$( "#primary-image-picker-modal" ).hide();
		} );
	} );
</script>
<div id="primary-image-picker-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p id="primary-image-picker-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med">
		{foreach from=$images item="image"}
			<img class="primary-image-picker-image image-picker-image" data-id="{$image->id}" data-src="{$HOME}public/img/uploads/{$image->filename}" src="{$HOME}public/img/uploads/{$image->filename}">
		{foreachelse}
			<p>No Images Uploaded Yet</p>
		{/foreach}
	</div>
</div>
