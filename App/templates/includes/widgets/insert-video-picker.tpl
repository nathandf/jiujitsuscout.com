<div id="insert-video-picker-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p id="insert-video-picker-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med border-std">
		{foreach from=$videos item="video"}
			<div>
				{if isset($video->filename) && isset($video->type)}
				<video style="border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;" controls>
				  <source src="{$HOME}public/videos/{$video->filename}" type="{$video->type}">
				  Your browser does not support the video tag.
				</video>
				{/if}
				<div class="clear"></div>
				<button class="btn btn-inline insert-video-picker-video video-picker-video push-t-med" data-id="{$video->id}" data-type="{$video->type}" data-src="{$root|default:'https://www.jiujitsuscout.com'}public/videos/{$video->filename}">Insert Video</button>
			</div>
			<div class="clear push-t-med"></div>
		{foreachelse}
			<p>No Videos Uploaded Yet</p>
		{/foreach}
	</div>

</div>
