{extends file="layouts/core.tpl"}

{block name="head"}
<script src="{$HOME}{$JS_SCRIPTS}quick-boi.js"></script>
{/block}

{block name="body"}
<div class="con-cnt-xlrg inner-pad-med">
	<h3>Model Builder</h3>
	{if !empty($error_messages.quick_boi)}
		{foreach from=$error_messages.quick_boi item=message}
			<div class="con-message-failure mat-hov cursor-pt --c-hide">
				<p class="user-message-body">{$message}</p>
			</div>
		{/foreach}
	{/if}
	{include file="includes/snippets/flash-messages.tpl"}
	<div class="push-t-med">
		<form action="" method="post">
			<input type="hidden" name="token" value="{$csrf_token}">
			<p class="text-sml">Model name:</p>
			<input id="model-name" type="text" name="model_name" class="inp inp-med-plus" required="required">
			<div class="hr"></div>
			<h3>Properties</h3>
			<button id="add-property" type="button" class="btn bg-deep-blue push-t-med">+ Property</button>
			<table id="property-table" class="col-100 push-t-med">
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">Name</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">Data Type</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">Values/Length</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">Null</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">Primary</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;">AI</th>
				<th class="bg-deep-blue tc-white text-sml" style="border: 1px solid #CCC;"></th>
			</table>
			<div class="hr"></div>
				<p class="text-sml">Engine:</p>
				<select class="inp inp-med cursor-pt" name="engine" id="">
					<option value="InnoDB" selected="selected">InnoDB</option>
				</select>
			</div>
			<div class="hr"></div>
			<input type="submit" class="btn bg-good-green push-t-sml" value="Create Model">
		</form>
	</div>
</div>
{/block}
