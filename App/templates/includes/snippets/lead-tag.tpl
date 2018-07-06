<?php

$uncontacted_initial_icon = '<i class="fa fa-exclamation" style="color: #FFF;" aria-hidden="true"></i></i>';
$uncontacted_icon_color = '#FF6666';

$appointment_indicator = "";
$follow_up_indicator = "";
$action_indicator = "";

$lead_first_initial = strtoupper(substr($lead[ "name" ], 0, 1));

$lead_icon_colors = ['#FF6373','#37BF91','#7A6FF0','#FDA32E','#4873A5','#70C9C5'];
$lead_icon_color = $lead_icon_colors[array_rand($lead_icon_colors, 1)];

if( $lead[ "times_contacted" ] < 1 && $lead[ "status" ] != 'won' && $lead[ "status" ] != 'lost')
{
	$action_indicator = '<div class="contact-indicator"><i class="fa fa-exclamation alert-icon" aria-hidden="true"></i></div>';
	$lead_first_initial = $uncontacted_initial_icon;
	$lead_icon_color = $uncontacted_icon_color;
}
elseif($lead[ "status" ] == 'won')
{
	#$action_indicator = '<div class="contact-indicator"><i class="fa fa-dollar" aria-hidden="true"></i></div>';
	$lead_first_initial = '<i class="fa fa-dollar" aria-hidden="true"></i>';
	$lead_icon_color = '#158A0C';
}
elseif($lead[ "status" ] == 'lost')
{
	#$action_indicator = '<div class="contact-indicator"><i class="fa fa-times" aria-hidden="true"></i></div>';
	$lead_first_initial = '<i class="fa fa-times" aria-hidden="true"></i>';
	$lead_icon_color = '#EB4441';
}

$display_name = str_shortener( $lead[ "name" ], 20 );
$display_email = str_shortener( $lead[ "email" ], 25);
$display_phone = str_shortener( $lead[ "phone_number" ], 25 );

if ( !empty( $lead[ "appointment_datetime" ] ) ) {
	$appointment_indicator = '<div class="appointment-container"><p><i style="padding-left: 6px; padding-right: 6px;" class="fa fa-clock-o apt-icon" aria-hidden="true"></i>' . $lead[ "appointment_datetime" ] . "</p></div>";
}
if ( !empty( $lead[ "follow_up_datetime" ] ) )
{
	$follow_up_indicator = '<div class="appointment-container"><p><i class="fa fa-calendar-plus-o fu-icon" aria-hidden="true"></i>' . $lead[ "follow_up_datetime" ] . "</p></div>";
}

?>

<div class="lead-container">

<?=$appointment_indicator?>
<?=$follow_up_indicator?>

<a href="lead?lid=<?=$lead[ "id" ]?>" id="lead<?=$lead[ "id" ]?>" class="lead-tag mat-hov">
		<span class="lead-icon" style="background: <?=$lead_icon_color?>"><?=$lead_first_initial?></span>
		<div class="lead-data">
			<?=$action_indicator?>
			<p class="lead-name"><?=$display_name?></p>
			<p><?=$display_phone?></p>
			<p><?=$display_email?></p>
		</div>

</a>
<div class="clear"></div>
</div><!-- end lead container -->

<div class="clear"></div>
