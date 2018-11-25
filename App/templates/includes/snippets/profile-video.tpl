{if isset($business->video->filename) && isset($business->video->type)}
<script type="application/ld+json">
{literal}
{
    "@context": "http://schema.org",
    "@type": "VideoObject",
    "name": "{/literal}{$business->video->name|default:'None'}{literal}",
    "description": "{/literal}{$business->video->description|default:'None'}{literal}",
    "uploadDate": {/literal}"{$business->video->created_at|date_format:'%A, %b %e %Y %l:%M%p'}"{literal},
    "contentUrl": "https://www.jiujitsuscout.com/public/videos/{/literal}{$business->video->filename}{literal}"
}
{/literal}
</script>

<div id="video" class="push-t-med push-b-med">
    <video class="profile-video" style="border: 2px solid #CCCCCC;" controls>
      <source src="{$HOME}public/videos/{$business->video->filename}" type="{$business->video->type}">
      Your browser does not support the video tag.
    </video>
</div>
{/if}
