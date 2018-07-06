<div class="modal-overlay mod-an" style="display: none" id="quick-email-modal">
  <div class="modal" id="">
    <div class="modal-header">
      <span class="modal-close" id="quick-email-modal-close">Close</span>
      <h2 class="section-title">Quick Email</h2>
    </div><!-- end modal-header -->
    <div class="modal-body-0p">
      <div class="post-modal">
        <form method="post" action="{$action|default:null}">
          <div class="qe-header">To</div>
          <input type="hidden" name="send_email" value="{$csrf_token}">
          <input type="hidden" name="token" value="{$csrf_token}">
          <textarea class="recipient" name="to_name" readonly="readonly">{$recipient_first_name|default:null}</textarea>
          <textarea class="recipient" name="to_email" readonly="readonly">{$recipient_email|default:null}</textarea>
          <div class="qe-header">From</div>
          <div class="sending-as">{$sender_first_name|default:null}</div>
          <div class="sender">{$sender_email|default:null}</div>
          <textarea class="inp email-subject" name="subject" placeholder="Email Subject"></textarea>
          <textarea class="inp notes" name="body" placeholder="Email Body"></textarea>
          <input type="hidden" name="action" value="emailed"/>
          <input type="submit" onclick="setClientNiceTime(); setClientUnixTimestamp();" name="send_email" class="action-btn-r" value="Send" />
          <p class="descriptions">Send {$recipient_first_name|default:"them"} a quick email</p>
          <div class="clear"></div>

        </form>
      </div><!-- end post-modal -->
    </div><!-- end modal-body -->
  </div><!-- end modal -->
</div><!-- end modal-overlay -->
