{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/forms/">< Back</a>
		<div class="clear push-t-med"></div>
		<p class="text-xlrg-heavy">{$form->name}</p>
		<div contenteditable id="form-html" class="inp" style="height: 300px; width: 80%; overflow-y: scroll;">
			<pre>
			{if $form->elements|@count < 1}
				This form doesn't have any elements yet.
			{else}
				<!-- BEGIN JIUJITSUSCOUT FORM -->
				<div>
				<form action="https://www.jiujitsuscout.com/forms/" class="jiujitsuscout_prospect_form" id="new_prospect_form_1598_html" method="post">
					<div style="position:absolute;left:-5000px;"><input type="text" name="test" tabindex="-1" value="--Some Value Here--" autocomplete="off"></div>
					<input type="hidden" name="token" value="--Form Token Goes Here--" />
					<table class='jiujitsuscout_form'>
					{foreach from=$form->elements item=element }
						{if $element->type->name != "submit"}
						<tr>
							<td>
								<label for="">{$element->type->name|capitalize}</label>
								<div class="clear"></div>
								<input autocomplete="off" id="" name="" type="text" />
							</td>
						</tr>
						{else}
						<tr>
							<td>
								<label for="">{$element->type->name|capitalize}</label>
								<div class="clear"></div>
								<input autocomplete="off" id="" name="" type="text" />
							</td>
						</tr>
						{/if}
					{/foreach}
					</table>
				</form>
				</div>
				<!-- END JIUJITSUSCOUT FORM -->
			{/if}
			</pre>
		</div>
		<div class="clear"></div>
		<a class="btn btn-inline bg-deep-blue text-med push-t-med" href="{$HOME}account-manager/business/form/{$form->id}/edit">Edit Form</a>
		<div class="clear"></div>
	</div>
{/block}
