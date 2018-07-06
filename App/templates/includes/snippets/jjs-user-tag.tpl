<div class="user-tag">
  <?php
  if($um_user_clearance == 99){$um_user_clearance = "***";}
  if($um_approved == 0){$approval_color = "red"; $approval_status = "Pending...";}else{$approval_color = "green"; $approval_status = "Approved";}
  ?>
  <span><b>Name:</b> <?=$um_first_name . " " . $um_last_name?></span>
  <span><b>Email:</b> <?=$um_username?></span>
  <span><b>Status:</b> <span style="color: <?=$approval_color?>"><?=$approval_status?></span></span>

  <div><b>User Clearance Level:</b> <?=$um_user_clearance?></div>
  <form id="user-permissions<?=$um_user_id?>" action="controller.php" method="POST">
    <input type="hidden" value="<?=$um_user_id?>" name="um_user_id">
    <input type="hidden" value="<?=$um_approved?>" name="um_approved">
    <select class="dropdown" form="user-permissions<?=$um_user_id?>" name="um_user_permission_level">
      <option name="um_user_permission_level" selected="selected" hidden="hidden" value="1">Select Permission</option>
      <option name="um_user_permission_level" value="1">1</option>
      <option name="um_user_permission_level" value="2">2</option>
      <option name="um_user_permission_level" value="3">3</option>
      <option name="um_user_permission_level" value="4">4</option>
      <option name="um_user_permission_level" value="5">5</option>
    </select>
    <input type="submit" class="update_button" name="update_user_permissions" value="Update Permissions">
    <input type="submit" class="delete_button" name="delete_user" value="Remove User">
  </form>

</div>
