{if isset($video->filename) && isset($video->type)}
<script type="application/ld+json">
{literal}
{
    "@context": "http://schema.org",
    "@type": "VideoObject",
    "name": "{/literal}{$video->name|default:'None'}{literal}",
    "description": "{/literal}{$video->description|default:'None'}{literal}",
    "uploadDate": {/literal}"{$video->created_at|date_format:'%A, %b %e %Y %l:%M%p'}"{literal},
    "contentUrl": "https://www.jiujitsuscout.com/public/videos/{/literal}{$video->filename}{literal}"
}
{/literal}
</script>

<video style="border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;" controls>
  <source src="{$HOME}public/videos/{$video->filename}" type="{$video->type}">
  Your browser does not support the video tag.
</video>
{/if}
