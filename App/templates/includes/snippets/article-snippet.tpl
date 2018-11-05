<div class="article-snippet-container mat-box-shadow push-t-med inner-pad-med" style="border: 1px solid #EEE;">
	<a style="text-decoration: none; display: block;" href="{$HOME}{$blog->url}/{$article->slug}">
		<img class="article-snippet-image floatleft" src="{$HOME}public/img/uploads/{$article->primary_image->filename}" alt="{$article->primary_image->alt}">
	</a>
	<div class="article-snippet floatleft push-l-med">
		<a style="display: inline-block;" class="article-snippet-link article-snippet-title" href="{$HOME}{$blog->url}/{$article->slug}">{$article->title}</a>
		<p class="article-snippet-description push-t-sml">{$article->meta_description}</p>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
