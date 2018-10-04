<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css"/>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div id="leads" class="con-cnt-xxlrg first inner-pad-med">
			<h2>Leads</h2>
			<a href="{$HOME}account-manager/business/add-lead" class="btn btn-inline leads first mat-hov"><span class="text-med">Add Lead <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear"></div>
			<!-- <input type="search" class="inp search-bar-std first" placeholder="Search">
			<div class="clear"></div> -->
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
					{if !empty($flash_messages)}
						{foreach from=$flash_messages item=message}
							<div class="con-message-success mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
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
									<select class="first inp field-sml floatleft cursor-pt" name="action" id="action" required="required">
										<option name="action" value="" hidden="hidden">-- Choose Action --</option>
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
									<tr>
										<td>
										</td>
										<td>
											<a  href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="lead-tag floatleft unpurchased mat-hov">
												<span class="lead-icon bg-good-green tc-black" style="color: #fff;"><i class="fa fa-user" aria-hidden="true"></i></span>
												<div class="lead-data">
													<p class="lead-name" style="display: inline-block; margin-top: 8px;">New Lead</p>
													<p class="text-lrg">{$business->currency->symbol}{$prospect->appraisal->value|string_format:"%.2f"}</p>
												</div>
												<div class="clear"></div>
											</a>
										</td>
									<tr>
									{else}
									<tr>
										<td>
											<input type="checkbox" name="lead_ids[]" value="{$prospect->id}" class="action-cb checkbox-med cursor-pt">
										</td>
										<td>
											{if $prospect->type == "trial"}
												<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="lead-tag trial first mat-hov floatleft">
													<span class="lead-icon icon-c-3"><i class="fa fa-calendar" aria-hidden="true"></i></span>
													<div class="lead-data">
														<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
														<p>{$prospect->phone_number|default:"Number: N/a"}</p>
														<p>{if $prospect->email}{$prospect->email|lower|truncate:20:"..."}{else}email: N/a{/if}</p>
													</div>
												</a>
											{elseif $prospect->type == "lead"}
												{if $prospect->times_contacted < 1}
													<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="lead-tag uncontacted first mat-hov floatleft">
														<span class="lead-icon icon-c-2"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
														<div class="lead-data">
															<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
															<p>{$prospect->phone_number|default:"Number: N/a"}</p>
															<p>{if $prospect->email}{$prospect->email|lower|truncate:23:"..."}{else}email: N/a{/if}</p>
														</div>
													</a>
												{else}
													<a href="{$HOME}account-manager/business/lead/{$prospect->id}/" id="lead{$prospect->id}" class="lead-tag first mat-hov floatleft">
														<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$prospect->first_name|substr:0:1|upper}</span>
														<div class="lead-data">
															<p class="lead-name">{$prospect->first_name|capitalize|truncate:20:"..."} {$prospect->last_name|capitalize|truncate:20:"..."}</p>
															<p>{$prospect->phone_number|default:"Number: N/a"}</p>
															<p>{if $prospect->email}{$prospect->email|lower|truncate:23:"..."}{else}email: N/a{/if}</p>
														</div>
													</a>
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
	</body>
</html>
