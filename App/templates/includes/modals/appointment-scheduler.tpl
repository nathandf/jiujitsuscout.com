<div class="modal-overlay mod-an" style="display: none" id="appointment-scheduler">
  <div class="modal" id="">
    <form id="appointment-scheduler-form" action="" method="post">
    <div class="modal-header">
      <span class="modal-close" onclick="closeModal('appointment-scheduler')" ontouch="closeModal('appointment-scheduler')" id="appointment-schedule-close">Close</span>
      <p><i class='fa fa-clock-o modal-icon' aria-hidden='true'></i> Schedule an Appointment for {$lead->name}</p>
    </div><!-- end modal-header -->
    <div class="modal-body">
      <label class="modal-label">Date:</label>
      <select name="year" form="appointment-scheduler-form" class="modal-select">
        <option name="year" hidden="hidden" selected="selected"></option>
        <option name="year" value="" >--</option>
        <option name="year" value="" >--</option>
        <option name="year" value="" >--</option>
      </select>
      <select class="modal-select" name="month" form="appointment-scheduler-form">
        <option name="month" hidden="hidden" value="" selected="selected">--</option>
      </select>
      <select class="modal-select" name="day" form="appointment-scheduler-form">
        <option name="day" hidden="hidden" selected="selected">--</option>
      </select>
      <div class="clear mobile" style="margin-top: 10px;"></div>
      <span class="ml-r"></span>
      <label class="modal-label">Time:</label>
      <select class="modal-select" name="hour" form="appointment-scheduler-form">
        <option name="hour" hidden="hidden" selected="selected"></option>
      </select>
      <span>:</span>
      <select class="modal-select" name="minute" form="appointment-scheduler-form">
        <option name="minute" value="0" selected="selected">00</option>
        <option name="minute" value="15">15</option>
        <option name="minute" value="30">30</option>
        <option name="minute" value="45">45</option>
      </select>
      <select class="modal-select" name="ampm" form="appointment-scheduler-form">
        <option name="ampm" hidden="hidden" value="pm" selected="selected">PM</option>
        <option name="ampm" value="am">AM</option>
        <option name="ampm" value="pm">PM</option>
      </select>
    </div><!-- end modal-body -->
    <div class="modal-footer">
      <input type="hidden" name="remind" value="1" />
      <input type="hidden" name="id" value="{$lead->id}">
      <input type="hidden" name="name" value="{$lead->name}">
      <input type="hidden" name="email" value="{$lead->email}">
      <input type="hidden" name="number" value="{$lead->phone_number}">
      <input type="hidden" name="action" value="appointment">
      <input type="hidden" name="schedule-action" value="1">
      <button type="submit" onclick="runTimeFunctions();" ontouch="runTimeFunctions();" name="appointment" value="true" class="modal-submit-button">Schedule</button><!-- end modal-button -->
      <div class="clear"></div>
    </div><!-- end modal-footer -->
    <input type="hidden" name="id" value="{$lead->id}">
  </form>
  </div><!-- end modal -->
</div><!-- end modal-overlay -->
