<div class="modal-overlay mod-an" style="display: none" id="reschedule-modal">
  <div class="modal" id="">
    <div class="modal-header">
      <span class="modal-close" id="reschedule-modal-close">Close</span>
      <h2 class="section-title">Reschedule Appointment</h2>
    </div><!-- end modal-header -->
    <div class="modal-body-0p">
      <div class="post-modal appointment-modal-body">
        <form method="post" action="{$HOME}account-manager/business/appointment/{$appointment->id}/update">
  				<input type="hidden" name="prospect_id" value="{$lead->id}">
          <input type="hidden" name="reschedule" value="true">
  				<h2>{$lead->first_name|capitalize} {$lead->last_name|capitalize}</h2><br>
  				<h3>Date</h3>
  				{html_select_date class="inp field-sml cursor-pt first" start_year='-1' end_year='+3'}
  				<div class="clear"></div>
  				<h3>Time</h3>
  				{html_select_time class="inp field-sml cursor-pt first" minute_interval=15 display_seconds=false use_24_hours=false}
  				<h3>Reminders</h3>
  				<input type="checkbox" id="remind_user" class="first cursor-pt" name="remind_user" class="cursor-pt" value="true" checked="checked"> <label for="remind_user">Send me a reminder </label>
  				<div class="clear"></div>
  				<input type="checkbox" id="remind_prospect" class="cursor-pt" name="remind_prospect" class="cursor-pt" value="true"> <label for="remind_prospect">Send {$lead->first_name} a reminder</label>
  				<input type="submit" class="btn bnt-inline floatright first" value="Reschedule Appointment">
  			</form>
        <div class="clear"></div>
      </div><!-- end modal-post -->

    </div><!-- end modal-body -->
  </div><!-- end modal -->
</div><!-- end modal-overlay -->
