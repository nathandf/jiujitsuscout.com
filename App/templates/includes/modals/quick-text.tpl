<div class="modal-overlay mod-an" style="display: none" id="quick-text-modal">
  <div class="modal" id="">
    <div class="modal-header">
    <span class="modal-close" id="quick-text-modal-close">Close</span>
    <h2 class="section-title">Text Messaging</h2>
    </div><!-- end modal-header -->
    <div class="modal-body-0p">
      <div class="sms-station">
        <div id="conversation-box" class="conversation-box">
          {foreach from=$sms_messages item=sms}
            <p id="{$sms->id}" class=''>{$sms->sms_body}<br>
            <span class='text-xsml time'>{$sms->utc_time_sent}</span></p>
            <div class='clear'></div>
          {/foreach}
        </div>
        <form action="./send-sms" method="post">
          <input type="text" name="sms_body" class="inp field-med-plus-plus sms-field" placeholder="Type your message here" required="required">
          <button type="submit" name="sendSMS" class="btn send-sms-btn">Send SMS</button>
        </form>
        <div class="clear"></div>
      </div>
    </div><!-- end modal-body -->
  </div><!-- end modal -->
</div><!-- end modal-overlay -->
