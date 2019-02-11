<div id="insert-image-picker-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p id="insert-image-picker-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med border-std">
		{foreach from=$images item="image"}
			<img class="insert-image-picker-image image-picker-image" data-id="{$image->id}" src="{$HOME}public/img/uploads/{$image->filename}" alt="{$image->alt}">
		{foreachelse}
			<p>No Images Uploaded Yet</p>
		{/foreach}
	</div>

</div>
