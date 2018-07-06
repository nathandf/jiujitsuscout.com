
<div class="lead-tag">

	<div class="column"><p><?=$gym_name?></p></div>
	<div class="column"><p><?=$name?></p></div>
	<div class="column"><p><?=$email?></p></div>
	<form id="delete_lead_form<?=$lead_id?>" onsubmit="return confirm('Are you sure you want delete this lead?');" method="post" action="delete.php">
	<input type="hidden" name="lead_id" value="<?=$lead_id?>">
	<div class="column">
		<button class="delete_button" form="delete_lead_form<?=$lead_id?>" name="delete_lead">
			<i style="color: red;" class="fa fa-times fa-2x" aria-hidden="true"></i>
		<button>
	</div>
	</form>
	<div class="clear"></div>

</div>
<div class="clear"></div>
