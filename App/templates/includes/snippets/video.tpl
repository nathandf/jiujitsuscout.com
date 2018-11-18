{if isset($video->filename) && isset($video->type)}
<video width="320" height="240" controls>
  <source src="{$HOME}public/videos/{$video->filename}" type="{$video->type}">
  Your browser does not support the video tag.
</video>
{/if}
