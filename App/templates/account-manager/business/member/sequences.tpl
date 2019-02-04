{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/sequence.css">
	<script src="{$HOME}{$JS_SCRIPTS}sequences.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xxlrg push-t-med inner-pad-med">
			<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/members">Members</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/member/{$member->id}/">{$member->getFullName()}</a> > Add to Sequence</p>
			<h2 class="push-t-med">Choose a sequence</h2>
			<p class="text-sml">Add {$member->getFullName()} to a follow up sequence.</p>
			<div class="hr-sml"></div>
			{if !empty($error_messages.add_to_sequence)}
				{foreach from=$error_messages.add_to_sequence item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<div class="clear push-t-med"></div>
			{foreach from=$inactiveSequenceTemplates item=sequence}
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_to_sequence" value="{$csrf_token}">
				<input type="hidden" name="sequence_template_id" value="{$sequence->id}">
				<div id="sequence-tag-{$sequence->id}" class="bg-white col-100 inner-pad-sml" style="box-sizing: border-box; border: 2px solid #CCCCCC; border-radius: 5px;">
					<button type="button" class="floatright btn btn-inline bg-deep-blue sequence-dropdown-toggle" style="margin-bottom: 0px;"> <i class="fa fa-plus" aria-hidden="true"></i></button>
					<p class="text-med-heavy">{$sequence->name}</p>
					<p class="text-med">{$sequence->description}</p>
					<div class="clear"></div>
					<div id="sequence-tag-{$sequence->id}-dropdown" class="push-t-sml" style="display: none;">
						<div class="hr-sml push-b-sml"></div>
						<input class="checkbox start-time-toggle" type="checkbox" checked="checked" name="start_immediately"> <label for="specific-end-date">Start Sequence Immediately</label>
						<div id="sequence-tag-{$sequence->id}-dropdown-time-select">
							<div class="hr-sml"></div>
							<div class="floatleft push-r-med push-t-sml">
								<p class="text-sml">Start Time Quantity</p>
								<input id="" type="quantity" class="inp field-sml" name="quantity" placeholder="Ex. 6">
							</div>
							<div class="floatleft push-r-med push-t-sml">
								<p class="text-sml">Unit</p>
								<select class="inp field-sml cursor-pt" name="unit" id="unit">
									<option value="weeks" selected="selected" hidden="hidden">Week(s)</option>
									<option id="day" value="days">Day(s)</option>
									<option id="week" value="weeks">Week(s)</option>
									<option id="month" value="months">Month(s)</option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<button type="submit" class="btn btn-inline bg-deep-blue floatright push-t-sml" style="margin-bottom: 0px;">Create Sequence</button>
						<div class="clear"></div>
					</div>
				</div>
			</form>

			<div class="clear push-t-med"></div>
			{foreachelse}
			{if !empty( $activeSequenceTemplates )}
				-- All sequences are currently in use --
			{else}
				-- No sequences available --
				<div class="clear push-t-med"></div>
				<a class="btn btn-inline bg-deep-blue text-med-heavy" href="{$HOME}account-manager/business/sequence/new">Create a Sequence Template +</a>
			{/if}
			{/foreach}
			{if !empty( $activeSequenceTemplates )}
				<div class="clear push-t-med hr-sml"></div>
				<h2>Active Sequences</h2>
				<p class="text-sml">{$member->getFullName()} is currently on these sequences</p>
				{foreach from=$activeSequenceTemplates item=activeSequenceTemplate}
				<form method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="delete_sequence" value="{$csrf_token}">
					<input type="hidden" name="sequence_id" value="{$activeSequenceTemplate->sequence->id}">
					<div class="bg-white col-100 inner-pad-sml push-t-med" style="box-sizing: border-box; border: 2px solid #CCCCCC; border-radius: 5px;">
						<button type="submit" class="floatright btn btn-inline bg-red --c-trash"> <i class="fa fa-trash" aria-hidden="true"></i></button>
						<p class="text-med-heavy">{$activeSequenceTemplate->name}</p>
						<p class="text-med">{$activeSequenceTemplate->description}</p>
					</div>
				</form>
				{/foreach}
			<div class="clear push-t-med"></div>
			{/if}
			{if !empty( $completedSequenceTemplates )}
				<div class="clear push-t-med hr-sml"></div>
				<h2>Completed Sequences</h2>
				<p class="text-sml">{$member->getFullName()} has completed these sequences</p>
				{foreach from=$completedSequenceTemplates item=completedSequenceTemplate}
				<div class="bg-white col-100 inner-pad-sml push-t-med" style="box-sizing: border-box; border: 2px solid #CCCCCC; border-radius: 5px;">
					<p class="floatright bg-good-green tc-white" style="padding: 5px; border-radius: 3px;"><i class="fa fa-check" aria-hidden="true"></i></p>
					<p class="text-med-heavy">{$completedSequenceTemplate->name}</p>
					<p class="text-med">{$completedSequenceTemplate->description}</p>
				</div>
				{/foreach}
			<div class="clear push-t-med"></div>
			{/if}
		</div>
	</div><!-- end content -->
{/block}
