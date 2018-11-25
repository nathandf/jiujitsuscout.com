{if !empty($flash_messages)}
	{foreach from=$flash_messages item=message}
		<div class="con-message-success mat-hov cursor-pt --c-hide">
			<p class="user-message-body">{$message}</p>
		</div>
	{/foreach}
{/if}
