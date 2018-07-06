<div class="school_tag featured">
	<img class="school_logo" src='<?=$featured_listings[ $iterator ][ 'school_photo_path' ]?>' />
	<div class="info_1">
		<a class="name" href="martial-arts-gyms/<?=$featured_listings[ $iterator ][ 'url_formatted_name' ]?>/"><?=$featured_listings[ $iterator ][ 'display_gym_name' ]?></a>
		<p class="featured_tag">Featured</p>
		<p><?= $featured_listings[ $iterator ][ 'rating_snippet' ] ?> <?= $featured_listings[ $iterator ][ 'gym_stars_html' ] ?> (<?=$featured_listings[ $iterator ][ 'gym_rating' ]?>)</p>
		<p >Reviews (<?=$featured_listings[ $iterator ][ 'total_ratings_reviews' ]?>)</p>
	</div>
		<span class="info_2">
			<b>Offer</b>
			<p><?=$featured_listings[ $iterator ][ 'promotional_offer' ]?></p>
			<div class="clear"></div>
		</span>
		<div class="clear"></div>
		<div class="review">
			<i class="fa fa-user-circle-o fa-2x user_icon" aria-hidden="true"></i><span><span class="review_name"><b><?= $featured_listings[ $iterator ][ 'review_snippet_name' ] ?></b></span><span class="review_text"> <?= $featured_listings[ $iterator ][ 'review_snippet_body' ] ?></span></span>
		</div>
</div>
<div class="clear"></div>
<!-- end school tag -->
