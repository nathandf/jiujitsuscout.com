{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div id="leads" class="con-cnt-xlrg push-t-med inner-pad-med">
		<h2>Leads</h2>
		<a href="{$HOME}account-manager/business/add-lead" class="btn btn-inline leads push-t-med mat-hov"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">Add Lead</span></a>
		<div class="clear"></div>
		<p class='results_count_message first'>Showing ({$prospects|@count}) Results</p>
		<div class="lead-box">
			<div id="lead-tag-container">
				{if !empty($error_messages.update_leads)}
					{foreach from=$error_messages.update_leads item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				{include file="includes/snippets/flash-messages.tpl"}
				<form method="post" action="{$HOME}account-manager/business/leads">
					<input type="hidden" name="update_leads" value="{$csrf_token}">
					<input type="hidden" name="token" value="{$csrf_token}">
					{if $prospects}
					<table>
						<tr>
							<td>
								<input id="master-checkbox" type="checkbox" class="checkbox-med cursor-pt push-r">
							</td>
							<td>
								<select class="first inp inp-sml floatleft cursor-pt" name="action" id="action" required="required">
									<option name="action" value="" hidden="hidden">Choose Action</option>
									<option name="action" value="contacted">Mark as Contacted</option>
									<option name="action" value="uncontacted">Mark as Uncontacted</option>
									<option name="action" value="member">Became Member</option>
									<option name="action" value="trash">Trash</option>
									{if $groups}
										<option name="action" value="">-- ADD TO GROUP --</option>
										{foreach from=$groups item=group}
										<option name="action" value="group-{$group->id}">{$group->name}</option>
										{/foreach}
									{/if}
								</select>
								<input type="submit" class="btn btn-inline text-sml floatleft push-l first" value="Apply">
								<div class="clear"></div>
							</td>
						</tr>
						{foreach from=$prospects item=prospect}
							{if $prospect->type == "trial" || $prospect->type == "lead"}
								{if $prospect->requires_purchase && !isset($prospect->prospect_purchase) && isset($prospect->appraisal)}
									{if in_array( $user->role, [ "owner", "administrator", "manager" ] )}
									<tr>
										<td>
										</td>
										<td>
											<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="tag floatleft unpurchased push-t-med mat-hov">
												<div class="lead-icon-container floatleft">
													<span class="lead-icon bg-good-green tc-black" style="color: #fff;"><i class="fa fa-user" aria-hidden="true"></i></span>
												</div>
												<div class="lead-data floatleft">
													<p class="lead-name">New Lead</p>
													<p class="text-lrg">{$business->currency->symbol}{$prospect->appraisal->value|string_format:"%.2f"}</p>
												</div>
												<div class="clear"></div>
											</a>
										</td>
									<tr>
									{/if}
								{else}
								<tr>
									<td>
										<input type="checkbox" name="lead_ids[]" value="{$prospect->id}" class="action-cb checkbox-med cursor-pt">
									</td>
									<td>
										{if $prospect->type == "trial"}
											<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="tag-no-pad trial push-t-med mat-hov floatleft" style="padding-bottom: 0px;">
												<div class="inner-pad-xsml">
													<div class="lead-icon-container floatleft">
														<span class="lead-icon icon-c-3"><i class="fa fa-calendar" aria-hidden="true"></i></span>
													</div>
													<div class="lead-data floatleft">
														<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
														<p>{$prospect->phone_number|default:"Number: N/a"}</p>
														<p class="push-b-sml">{$prospect->email|truncate:20:"..."|default:"No email"}</p>
													</div>
												</div>
												<div class="clear col-100" style="border-top: 2px solid #FDA32E;"></div>
												<p class="text-med tc-dark-grey push-l-sml push-r-sml">Interactions:<span class="floatright text-lrg-heavy{if $prospect->times_contacted < 1} tc-red{else} tc-black{/if}">{$prospect->times_contacted}</span></p>
											</a>
										{elseif $prospect->type == "lead"}
											{if $prospect->times_contacted < 1}
												<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="tag-no-pad uncontacted push-t-med mat-hov floatleft" style="padding-bottom: 0px;">
													<div class="inner-pad-xsml">
														<div class="lead-icon-container floatleft">
															<span class="lead-icon icon-c-2"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
														</div>
														<div class="lead-data floatleft">
															<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
															<p>{$prospect->phone_number|default:"Number: N/a"}</p>
															<p class="push-b-sml">{$prospect->email|truncate:20:"..."|default:"No email"}</p>
														</div>
													</div>
													<div class="clear col-100" style="border-top: 2px solid #FF6373;"></div>
													<p class="text-med tc-dark-grey push-l-sml push-r-sml">Interactions:<span class="floatright text-lrg-heavy{if $prospect->times_contacted < 1} tc-red{else} tc-black{/if}">{$prospect->times_contacted}</span></p>
												</a>
											{else}
												{if $prospect->appointments|@count > 0}
												<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="tag-no-pad push-t-med mat-hov floatleft" style="border: 2px solid #7A6FF0; padding-bottom: 0px;">
													<div class="inner-pad-xsml">
														<div class="inner-pad-xsml">
															<div class="lead-icon-container floatleft">
																<span class="lead-icon bg-lavender"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
															</div>
															<div class="lead-data floatleft">
																<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
																<p>{$prospect->phone_number|default:"Number: N/a"}</p>
																<p class="push-b-sml">{$prospect->email|truncate:20:"..."|default:"No email"}</p>
															</div>
														</div>
													</div>
													<div class="clear col-100" style="border-top: 2px solid #7A6FF0;"></div>
													<p class="text-med tc-dark-grey push-l-sml push-r-sml">Interactions:<span class="floatright text-lrg-heavy{if $prospect->times_contacted < 1} tc-red{else} tc-black{/if}">{$prospect->times_contacted}</span></p>
												</a>
												{else}
												<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="tag-no-pad push-t-med mat-hov floatleft" style="padding-bottom: 0px;">
													<div class="inner-pad-xsml">
														<div class="lead-icon-container floatleft">
															<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$prospect->first_name|substr:0:1|upper}</span>
														</div>
														<div class="lead-data floatleft">
															<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
															<p>{$prospect->phone_number|default:"Number: N/a"}</p>
															<p class="push-b-sml">{$prospect->email|truncate:20:"..."|default:"No email"}</p>
														</div>
													</div>
													<div class="clear col-100" style="border-top: 2px solid #CCCCCC;"></div>
													<p class="text-med tc-dark-grey push-l-sml push-r-sml">Interactions:<span class="floatright text-lrg-heavy{if $prospect->times_contacted < 1} tc-red{else} tc-black{/if}">{$prospect->times_contacted}</span></p>
												</a>
												{/if}
											{/if}
										{/if}
									</td>
								<tr>
								{/if}
							{/if}
						{/foreach}
					</table>
					{/if}
				</form>
			</div>
			<div class="clear"></div>
		</div><!-- end lead-box -->
		<div class="clear"></div>
	</div>
{/block}
