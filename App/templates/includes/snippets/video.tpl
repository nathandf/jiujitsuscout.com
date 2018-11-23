{if isset($video->filename) && isset($video->type)}
<video style="border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;" controls>
  <source src="{$HOME}public/videos/{$video->filename}" type="{$video->type}">
  Your browser does not support the video tag.
</video>
{/if}
