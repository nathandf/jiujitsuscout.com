<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/admin-head.tpl"}
	</head>
	<body>
	    {include file="includes/navigation/admin-menu.tpl"}
	    <div class="con-cnt-xxlrg">
			<div class="bg-white push-t-med" style="border-bottom: 1px solid #333; padding: 10px; box-sizing: border-box;">
			    <div class="push-r-med floatleft">
			        <img itemprop="image" alt="{$business->business_name}'s logo - Martial Arts classes in {$business->city}, {$business->region}" src="{$HOME}public/img/uploads/{$business->logo_filename}" class="img-xsml"/>
			    </div>
			    <div class="floatleft">
			        <h1 style="font-family: 'Open Sans', Tahoma, sans-serif; font-size: 35px; line-height: 50px; display: block;">{$business->business_name}</h1>
			    </div>
			    <div class="clear"></div>
			</div>
			<table cellspacing="0" class="con-cnt-xxlrg push-b-med">
				<tr class="bg-green">
					<th class="tc-white">Account Type</th>
					<th class="tc-white">--</th>
				</tr>
				<tr class="bg-white">
					<td class="text-center">{$account_type->name|capitalize}</td>
					<td class="text-center">
						<form action="" method="post">
							<input type="hidden" name="token" value={$csrf_token}>
							<input type="hidden" name="account_type_update" value={$csrf_token}>
							<select class="inp field-sml push-t-med cursor-pt" name="account_type_id" id="">
								{foreach from=$account_types item=account_type}
								<option value="{$account_type->id}">{$account_type->name}</option>
								{/foreach}
							</select>
							<button type="submit" class="btn btn-inline">Update</button>
						</form>
					</td>
				</tr>
			</table>
			<div class="clear"></div>
		</div>
	</body>
</html>
