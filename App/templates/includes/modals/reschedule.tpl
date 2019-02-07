<div id="reschedule-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-lrg bg-white inner-pad-med push-t-med border-std">
		<form method="post" action="">
            <input type="hidden" name="token" value="{$csrf_token}">
            <input type="hidden" name="reschedule" value="true">
            <h2>Reschedule</h2>
			<div class="push-t-med">
				<p class="text-sml">Date</p>
	            {html_select_date class="inp inp-sml cursor-pt push-b-med" start_year='-1' end_year='+3'}
	            <div class="clear"></div>
	            <p class="text-sml">Time</p>
	            {html_select_time class="inp inp-sml cursor-pt push-b-med" minute_interval=15 display_seconds=false use_24_hours=false}
	            <input type="submit" class="btn bnt-inline push-t-med" value="Reschedule">
			</div>
  		</form>
	</div>
</div>
