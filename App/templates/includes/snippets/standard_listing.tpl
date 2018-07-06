<div class="school_tag">
	<img class="school_logo" src='<?=$gym_info[ $iterator ][ 'school_photo_path' ]?>' />
	<div class="info_1">
		<a class="name" href="martial-arts-gyms/<?=$gym_info[ $iterator ][ 'url_formatted_name' ]?>/"><?=$gym_info[ $iterator ][ 'display_gym_name' ]?></a>
		<p><?= $gym_info[ $iterator ][ 'rating_snippet' ] ?> <?= $gym_info[ $iterator ][ 'gym_stars_html' ] ?> (<?=$gym_info[ $iterator ][ 'gym_rating' ]?>)</p>
		<p >Reviews (<?=$gym_info[ $iterator ][ 'total_ratings_reviews' ]?>)</p>
	</div>
		<span class="info_2">
			<b>Offer</b>
			<p><?=$gym_info[ $iterator ][ 'promotional_offer' ]?></p>
			<div class="clear"></div>
		</span>
		<div class="clear"></div>
		<div class="review">
			<i class="fa fa-user-circle-o fa-2x user_icon" aria-hidden="true"></i><span><span class="review_name"><b><?= $gym_info[ $iterator ][ 'review_snippet_name' ] ?></b></span><span class="review_text"> <?= $gym_info[ $iterator ][ 'review_snippet_body' ] ?></span></span>
		</div>
</div>
<div class="clear"></div>
<!-- end school tag -->
