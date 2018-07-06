<?php
$generate_leads = Array();

$sql = $con->prepare("SELECT * FROM leads WHERE gym_name = :gymname");
$sql->bindParam(':gymname',$gymname);
$sql->execute();

while($row = $sql->fetch(PDO::FETCH_ASSOC)){

	$generate_leads[] = $row;
}

$total_generate_leads = count($generate_leads);

 ?>
<div id="call-list-form" class="call-list-form">
	<div class="call-list-form-title" ><p class="title">Generate Call-List<span class="add-lead-close title"><a href='./'><i class="fa fa-times" aria-hidden="true"></i></a></span></p></div>
	<div class="clear"></div>

	<p class="call-list-form-body">FEATURE COMING SOON - (Status: Disabled)<p>

	<p class="call-list-form-body">Generate a downloadable call-list for yourself or an employee<p>

	<form id="lead-form" method="POST" action="controller.php">
		<?php
			$i = 0;
			while($i < $total_generate_leads){
				echo('<input type="checkbox" class="call_list_check_box" name="lead'.$generate_leads[$i]['id'].'" /><lable class="cl-lable"> '.$generate_leads[$i]['id'].' - '.$generate_leads[$i]['name'].' - '.$generate_leads[$i]['phone_number'].' - '.$generate_leads[$i]['email'].'</lable>');
				echo('<div class="clear"></div>');
				$i++;
			}


		?>

		<input type="submit" class="call_list_modal_btn" name="call-list" disabled="disabled" value="GENERATE" />
		<div class="clear"></div>


	</form>

</div><!-- end sign-up-form -->
