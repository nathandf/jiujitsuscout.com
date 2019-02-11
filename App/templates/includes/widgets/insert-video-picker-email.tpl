<div id="insert-video-picker-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p id="insert-video-picker-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med border-std">
		{foreach from=$videos item="video"}
			<div class="clear push-t-sml"></div>
			<div>
				{if isset($video->filename) && isset($video->type)}
				<p class="text-lrg-heavy">{$video->name}</p>
				<p class="text-sml">{$video->description}</p>
				<video style="border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;" controls>
				  <source src="{$HOME}public/videos/{$video->filename}" type="{$video->type}">
				  Your browser does not support the video tag.
				</video>
				{/if}
				<div class="clear"></div>
				<button class="btn btn-inline insert-video-picker-video video-picker-video push-t-med" data-id="{$video->id}">Insert Video</button>
			</div>
			<div class="hr-sml push-t-sml"></div>
		{foreachelse}
			<p>No Videos Uploaded Yet</p>
		{/foreach}
	</div>

</div>
