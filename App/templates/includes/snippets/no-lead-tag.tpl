<?php

$quick_note_display = "none"; // temporary

$name = "Need More Leads?";
$phone = 3468007989;
$email = 'jiujitsuscout@gmail.com';
$times_contacted = 0;

$lead_first_initial = strtoupper(substr($name, 0, 1));

$lead_icon_colors = ['#FF6373','#37BF91','#7A6FF0','#FDA32E','#4873A5','#70C9C5'];
$lead_icon_color = $lead_icon_colors[array_rand($lead_icon_colors, 1)];

$contact_indicator = "";

if($times_contacted < 1)
{
	$status = "Not Contacted";
	$contact_indicator = '<div class="contact-indicator"><i class="fa fa-exclamation alert-icon" aria-hidden="true"></i></div>';
}
?>

<div class="lead-container">
<p>No Leads to Show</p>
<div id="lead0" class="lead-tag">
		<span class="lead-icon" style="background: <?=$lead_icon_color?>"><?=$lead_first_initial?></span>
		<div class="lead-data">
			<?=$contact_indicator?>
			<p class="lead-name"><?=$name?></p>
			<p><?=$phone?></p>
			<p><?=$email?></p>
		</div>
</div>

<div class="clear"></div>

<a href="tel:<?=$phone?>" class="call-icon-50">Call <i class="fa fa-phone" aria-hidden="true"></i></a>

</div><!-- end lead container -->
<div class="clear"></div>
