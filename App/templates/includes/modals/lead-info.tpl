<div class="modal-overlay mod-an" style="display: none" id="lead-info-modal">
  <div class="modal" id="">
    <div class="modal-header">
      <span class="modal-close" onclick="closeModal('lead-info-modal')" ontouch="closeModal('lead-info-modal')" id="lead-info-modal-close">Close</span>
      <h2 class="section-title">Contact Info</h2>
    </div><!-- end modal-header -->
    <div class="modal-body-0p">
      <div class="post-modal">
        <form method="POST" action="">
          <input type="hidden" name="id" value="{$lead->id}">
          <table class="lead-info">
            <tr>
              <td class="lead-info-title"><p class="hud-label">First Name</p></td>
              <td class="lead-info-title"><p class="hud-label">Email</p></td>
              <td class="lead-info-title"><p class="hud-label">Number</p></td>
            </tr>
            <tr>
              <td class="hud"><textarea name="name" class="hud-txt">{$lead->first_name}</textarea></td>
              <td class="hud"><textarea name="email" class="hud-txt email">{$lead->email}</textarea></td>
              <td class="hud"><textarea name="number" class="hud-txt">{$lead->phone_number}</textarea></td>
            </tr>
          </table>
          <input type="submit" name="update_lead" class="action-btn-r" value="Update"/>

        </form>

        <form method="POST" action="" onsubmit="return confirm('Trash this lead?');">
          <input type="hidden" name="id" value="{$lead->id}" />
          <button type="submit" onclick="runTimeFunctions();" name="delete_lead" value="delete" class="action-btn-l trash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
        </form>
        <div class="clear"></div>
      </div><!-- end modal-post -->

    </div><!-- end modal-body -->
  </div><!-- end modal -->
</div><!-- end modal-overlay -->
