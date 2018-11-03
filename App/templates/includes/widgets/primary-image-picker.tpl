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
