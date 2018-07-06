<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
		<link type="text/css" rel="stylesheet" href="<?=REL?>css/partner-lead.css">
		<script rel="text/javascript" src="<?=REL . JS_SCRIPTS?>lead.js"></script>
	</head>
	<body>
		<?php require_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div id="content">
			<div class="clear"></div>
			<div class="lead-manager-container">
				<a class="mat-hov" href="<?=HOME?>jjs-admin/partners/#partner<?=$Partner[ "id" ]?>"><i style="color: #fff; background: #40454E; border-radius: 3px; padding: 0px 5px 0px 5px;" class="fa fa-2x fa-angle-double-left" aria-hidden="true"></i></a>
				<div class="clear"></div>
				<div class="contact_display">
					<p class="top-name"><?=$Partner[ "contact_name" ]?> <i id="lead-info-button" onclick="triggerModal('lead-info-modal');" ontouch="triggerModal('lead-info-modal');" class="update fa fa-pencil" aria-hidden="true"></i></p>
					<p class="top-number"><?=$Partner[ "phone_number" ]?></p>
					<p class="section-title-outer">Contacts Made: <b><?=$Lead[ "times_contacted" ]?></b></p>
				</div>
				<button id="status-btn" class="status-btn" onclick="triggerModal('status-modal');" ontouch="triggerModal('status-modal');">Status <i class="fa fa-dollar" aria-hidden="true"></i></button>
				<button id="tools-btn" class="tools-btn" onclick="triggerModal('tools-modal');" ontouch="triggerModal('tools-modal');">Tools <i class="fa fa-wrench" aria-hidden="true"></i></button>
				<button id="appointments-btn" class="appts-btn" onclick="triggerModal('appointments-modal');" ontouch="triggerModal('appointments-modal');">Appts. <i class="fa fa-clock-o" aria-hidden="true"></i></button>
				<div class="clear"></div>
				<div id="appointments-modal" class="tools-modal mod-an" style="display: none;">
				  <p class="appointments_title">Appointments and Follow-ups</p>
				  <button type="button" id="follow-up-button" onclick="scrollToTop(); triggerModal('follow-up-scheduler');" ontouch="scrollToTop(); triggerModal('follow-up-scheduler');" name="post_action" value="follow-up" class="tool-btn tool-btn-50 follow-up">Schedule Follow-up<br><i class='fa fa-calendar-plus-o' aria-hidden='true'></i></button>
				  <button type="button" id="appointment-scheduler-button" onclick="scrollToTop(); triggerModal('appointment-scheduler');" ontouch="scrollToTop(); triggerModal('appointment-scheduler');" name="post_action" value="appointment" class="tool-btn tool-btn-50 appointment">Schedule Appt.<br><i class='fa fa-clock-o' aria-hidden='true'></i></button>
				  <div class="clear"></div>
				  <div id="appointments_container" class="appointments_container">
				    <?php
				    if( count( $PendingAppointments ) > 0)
				    {
				      foreach( $PendingAppointments as $appointment)
				      {
				        if ( $appointment['action'] == 'appointment' ) {
				          include( TEMPLATES . 'snippets/appointment-tag.php');
				        } elseif ( $appointment['action'] == 'follow-up' ) {
				          include( TEMPLATES . 'snippets/follow-up-tag.php');
				        }
				      }
				    }
				    else {
				      echo("
				          <div class='appointment_notes last-note'>
				          <p>No appointments set for {$Lead[ "name" ]}</p>
				          </div>
				          ");
				    }
				    ?>
				  </div><!-- end appointments_container -->
				</div>
				<div class="clear"></div>


				<h2 class="section-title-outer">Simple Note</h2>
				<div class="post">

				</div><!-- end post -->
				<div class="clear"></div>
				<div class="post-notes">
				<div id="lead-notes" class="lead_notes_container">
				<?php
					$i = 0;
					if($total_LeadNotes < 1)
					{
						echo("
										<div class='lead_notes last-note'>
											<p class='author_text'>Have a <span class='author'>super</span> productive day</p>
											<p class='body'>Write your first note for {$Lead[ "name" ]}!</p>
										</div>
								");
					}
					else
					{
						foreach( $LeadNotes as $LeadNote )
						{
							$note_special_class = "";
							$actions = ['post', 'called', 'texted', 'voicemail', 'emailed', 'follow-up', 'appointment', 'won', 'lost'];
							$icons = [
								'post' => '<i class="fa fa-sticky-note" aria-hidden="true"></i>',
								'called' => "<i class='fa fa-phone' aria-hidden='true'></i>",
								'texted' => "<i class='fa fa-comments-o' aria-hidden='true'></i>",
								'voicemail' => "<i class='fa fa-bullhorn' aria-hidden='true'></i>",
								'emailed' => "<i class='fa fa-envelope-o' aria-hidden='true'></i>",
								'follow-up' => "<i class='fa fa-calendar-plus-o' aria-hidden='true'></i>",
								'appointment' => "<i class='fa fa-clock-o' aria-hidden='true'></i>",
								'won' => "<i class='fa fa-dollar' aria-hidden='true'></i>",
								'lost' => "<i class='fa fa-times' aria-hidden='true'></i>"
							];
							foreach ( $actions as $action ) {
								if ( $LeadNote[ "action" ] == $action && $LeadNote[ "action" ] != 'post' ) {
									$action_icon = "<p class='action-icon-l {$LeadNote[ "action" ]}'>{$icons[$LeadNote[ "action" ]]}</p>";
								}
								if ( $LeadNote[ "action" ] == 'post' ) {
									$action_icon = "";
								}
							}
							echo("
										<div id='lead_note{$LeadNote[ 'id' ]}' class='lead_notes {$note_special_class}'>
											{$action_icon}
											<form method='post' action=''>
												<input type='hidden' name='note_type' value='{$LeadNote[ 'action' ]}'>
												<input type='hidden' name='id' value='{$LeadNote[ 'id' ]}'>
												<input type='hidden' name='lead_id' value='{$Lead[ 'id' ]}'>
												<input type='submit' name='delete_note' class='delete_note' value='x'>
											</form>
											<p class='author_text'>by <span class='author'>{$LeadNote[ "author" ]}</span> on <span class='timestamp'>{$LeadNote[ "nice_timestamp" ]}</span></p>
											<div class='clear'></div>
											<p class='body'>{$LeadNote['body']}</p>
										</div>
									");
						}
					}
				?>
				</div><!-- end lead_notes_container-->
			</div>

			</div><!-- end lead-manager-container -->

			<div class="clear"></div>

		</div><!-- end content -->
	</body>
</html>
