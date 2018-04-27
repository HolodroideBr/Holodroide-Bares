	<div>

	<div>

            	<div>
            <div style="display: none" id="thank_you" title="Submitted">
             <p> 
                     <?php
                    echo ' <img src="images/thank_you.jpg"> ';
                    ?>
            </p>
  <p>We received your message</p>

</div>
	<div id="formwrapper"> 
		<form action="includes/process.php" method="post" name="contact" id="contact">
			<div>
				<label for="name" class="label text-muted">Name </label>
				<input name="name" type="text" id="name">
			</div>
			<div>
				<label for="email" class="label">E-mail Address</label>
				<input name="email" type="text" id="email">
			</div>
			<div>
				<label for="Subject" class="label">Subject</label>
				<input name="Subject" type="text" id="Subject">
			</div>
                    	<div>
				<label for="url" class="label">website</label>
				<input name="url" type="text" id="url">
			</div>
			<div>
				<label for="message" class="label">Your Message</label>
				<textarea name="message" id="message_box" style="width: 280px; height: 134px"></textarea>
			</div>
						</div>
			<div id="captcha_box">

                            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" style="display: block"/>

			<input type="text" name="captcha_code" size="10" maxlength="6" />
<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[Different Image]</a>
</div>
        <div>
				<input type="submit" name="submit" id="submit" value="Submit" >
			</div>
		</form>
		</div>
		</div>
	</div>