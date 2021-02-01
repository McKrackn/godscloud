<?php
include 'utility/usercheck.php';

?>
<blockquote class="rounded-pill blockquote text-right h3">
	Es gibt keine größere Liebe, als wenn einer sein Leben für seine Freunde hingibt.
  <footer class="blockquote-footer text-monospace">Johannes 15:13 </footer>
</blockquote>

<div class="jumbotron content">
	<div class="contentborder">
		
    <ul class="nav nav-tabs border-white sticky-top" style="background-color: inherit;" role="tablist">
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#all">crowd cloud<p style="font-size:70%; text-align:center; margin-bottom: 0;">(alle)</p></a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#friends">proud cloud<p style="font-size:70%; text-align:center; margin-bottom: 0;">(Freunde)</p></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#blocked">fraud cloud<p style="font-size:70%; text-align:center; margin-bottom: 0;">(blockierte)</p></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#messages">Nachrichten<p style="font-size:70%; text-align:center; margin-bottom: 0;">(<?php echo $db->getUnreadMsg($_SESSION['actuser']->getId()) ?> ungelesen)</p></a>
    </li>
	<p class="small font-weight-bold text-right text-monospace position-absolute" style="right: 2%; margin: revert; border: none; padding-top: 1%;">wer nicht gleich sein Leben geben will, kann auch nur eine Nachricht schreiben.</p>
  </ul>

  <!-- Tabs -->
  <div class="tab-content">
    <div id="all" class="container tab-pane fade"><br>
      <h4>Crowd Cloud - alle sichtbaren Engel</h4>
		<?php include "inc/usersuche.php"; ?>
	</div>
    <div id="friends" class="container tab-pane active"><br>
      <h4>Proud Cloud - alle befreundeten Engel</h4>
	  <?php include "inc/friendsuche.php"; ?>
    </div>
    <div id="blocked" class="container tab-pane fade"><br>
      <h4>Fraud Cloud - alle in Ungnade Gefallenen</h4>
	  <?php include "inc/blocksuche.php"; ?>
    </div>
    <div id="messages" class="container tab-pane fade"><br>
      <h4>Nachrichten</h4>
	  <?php include "inc/messages.php"; ?>
    </div>
  </div>
</div>

</div>

  
<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="sendMsg" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content bg-light">
			  <div class="modal-header">
				<h5 class="modal-title" id="msgTitle">Nachricht an ---</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body">
			  <form  style="margin-top:2em;" method="POST">
				<div class="form-group">
       		        <label for="subject"><b>Betreff</b></label>
					<input type="text" name="subject" id="subject" class="form-control mb" required>
					<br>
					<label for="msgbody"><b>Ihre Nachricht</b></label>
					<textarea id="msgbody" name="msgbody" class="form-control mb" rows="7" required></textarea>
					<br>
					<label for="name"><b>Von</b></label>
					<input type="text" name="name" id="name" class="form-control mb" value="<?php echo str_replace("noUser", "---", $_SESSION['logusername']) ?>" disabled>
				</div>
                <br><button class="btn btn-dark btn-block" type="submit" name="msg" value="contact" id="msgBtn"><h4>in den Himmel damit!</h4></button>
		    </form> 
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
    	</div>
	</div>
</div>

