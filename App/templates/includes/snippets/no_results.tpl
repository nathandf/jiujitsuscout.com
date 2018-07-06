<div id="results" class="school-tag-not-found">
	<p class="no-entries">There are no entries found within a <?=$radius?> mile radius of <?=$search?></p>
	<p class="no-entries"><span style="color: green; font-weight: 600; text-decoration: underline;">BUT DON'T WORRY!</span><br>
		Just enter your info below and a professional martial arts instructor in your area will contact you in 24hrs or less!
	</p>
	<div class="gym-update-box">
	<h2>Get in contact with a martial arts gym near you</h2>

		<form method="post" action="thank-you">
			<input type="text" name="name" placeholder="Name" required="required">
			<input type="email" name="email" placeholder="Email" required="required">
			<input type="text" name="number" placeholder="Phone Number" required="required">
			<input type="hidden" name="source" value="no_entries_contact_me">
			<input type="hidden" name="postal_code" value="<?=$zip?>">
			<input type="submit" name="contact_me_submit" value="Get In Contact">
		</form>

	</div>

	<div class="l-txt">
		<span style="text-align: center; font-size: 25px; color: #236b8e">Can't Find Any Schools?</span><br>
		<p>-Try increasing your search radius or enter another zip code<br>
		-If you do not get any results again, it may be that the schools in the area have not yet contacted us to set up a free account.</p><br>

	</div>
	<div class="r-txt">
		<span style="text-align: center; font-size: 25px; color: #236b8e">Own A School In This Area?</span><br>
	<p>-If you own or work at any BJJ, MMA, Kickboxing, or other martial arts academies that are not in our network, you can
		set up a free account by clicking <a href="http://www.jiujitsuscout.com/partner/sign-up">here</a>. or calling (346) 800-7989</p>
	</div>
	<div class="clear"></div>
</div>

<div class="seperator"></div>
