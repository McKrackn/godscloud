<?php

?>
<blockquote class="rounded-pill blockquote text-right h3">
	Am Anfang war das Wort, und das Wort war bei Gott, und das Wort war Gott.
	<footer class="blockquote-footer text-monospace">Johannes 1:1</footer>
</blockquote>
		<div class="jumbotron content">
<div class="contentborder">
			<p class="small font-weight-bold text-right text-monospace">Gebete, Psalme oder sogar Seligsprechungen? Welches Thema es auch ist, wir freuen uns über Ihre gesegnete Kontaktaufnahme!</p>
       		<form  style="margin-top:2em;" method="POST">
				<div class="form-group">
       		        <label for="subject"><b>Betreff Ihres Anliegens</b></label>
					<input type="text" name="subject" id="subject" class="form-control mb" required>
					<br>
					<label for="message"><b>Details</b></label>
					<textarea id="message" name="message" class="form-control mb" rows="9" required></textarea>
					<br>
					<label for="name"><b>Name</b></label>
					<input type="text" name="name" id="name" class="form-control mb" value="<?php echo str_replace("noLoggedUser", "---", $_SESSION['logusername']) ?>">
				</div>
                <br><button class="btn btn-dark btn-block" type="submit" name="contact" value="contact"><h4>in den Himmel damit!</h4></button>
		    </form> 
        </div>

		</div>

