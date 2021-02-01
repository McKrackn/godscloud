<?php

?>
<blockquote class="rounded-pill blockquote text-right h3" style="background-color: #840c0c; box-shadow: 14px -20px 1px 0px rgba(219, 69, 69, 0.55);">
	Am Anfang war das Wort, und das Wort war bei Gott, und das Wort war Gott.
	<footer class="blockquote-footer text-monospace">Johannes 1:1</footer>
</blockquote>
		<div class="jumbotron content" style="border: 2rem solid #eb7d29;">
<div class="contentborder" style="background: red; color: yellow;">
			<p class="small font-weight-bold text-right text-monospace">Wird es zu warm in der Hölle?</p>
       		<form  style="margin-top:2em;" method="POST">
				<div class="form-group">
       		        <label for="subject"><b>Betreff Ihres Flehens</b></label>
					<input type="text" name="subject" id="subject" class="form-control mb" required>
					<br>
					<label for="message"><b>Details</b></label>
					<textarea id="message" name="message" class="form-control mb" rows="9" required></textarea>
					<br>
					<label for="name"><b>Sünder</b></label>
					<input type="text" name="name" id="name" class="form-control mb" value="<?php echo str_replace("noLoggedUser", "---", $_SESSION['logusername']) ?>">
				</div>
                <br><button class="btn btn-warning btn-block" type="submit" name="contact" value="contact"><h4>aus der Hölle damit!</h4></button>
		    </form> 
        </div>

		</div>

