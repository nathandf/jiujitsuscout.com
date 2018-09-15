<div style="display: none; overflow-y: scroll;" class="lightbox business-images-lightbox inner-pad-med">
	<p class="business-images-lightbox-close floatright cursor-pt tc-white"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear push-t-lrg"></div>
	{foreach from=$images item=image name=image_loop}
		<img style="width: 90%; border: 1px solid #CCC; border-radius: 3px; background: #FFF; display: block; margin: 0 auto; margin-top: 20px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="">
	{/foreach}
</div>
