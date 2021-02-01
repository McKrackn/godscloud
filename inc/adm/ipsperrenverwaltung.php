<?php
include 'utility/admincheck.php';

?>
	<blockquote class="rounded-pill blockquote text-right h3">
		Sündigt aber dein Bruder, so geh hin und weise ihn zurecht.
			<footer class="blockquote-footer text-monospace">Matthäus 18:15</footer>
	</blockquote>	
	<div class="jumbotron content" style="position: absolute">
	<div class="contentborder">
		<p class="small font-weight-bold text-right text-monospace"><b>Definition Sünde: </b>Nach fünf fehlgeschlagenen Login-Versuchen hintereinander (ein erfolgreicher Login setzt den Zähler zurück) wird eine IP-Adresse gesperrt.</p> 
	<div class="row">
	<div class="col-md-12">

	<div class="panel panel-default">
	<div class="panel-body">

	<table class="display table table-striped table-bordered table-hover bg bg-light" cellspacing="0" width="100%">
		<thead><tr>
		<th>#</th>
		<th onclick="sortTablenum(0)">IP-Adresse</th>
			<th onclick="sortTable(1)">erster Fail</th>
			<th onclick="sortTable(2)">letzter Fail</th>
			<th onclick="sortTablenum(3)"># Fails</th>
		<th>Aktion</th>	
		</tr></thead>
		<tbody id ="results">
		<?php
		$results=$db->getIPsperren();
			$cnt=1;
			foreach($results as $result) {
				?>	
							<tr>
								<td><?php if ($result["failcount"]>4) { ?>
								<i class="fa fa-exclamation-triangle" style="color:red"></i>
								<?php } else echo htmlentities($cnt);?></td>
								<td><?php if (strcasecmp($result["logip"],$_SERVER["REMOTE_ADDR"]) ==0)
										echo htmlentities($result["logip"]), '  -- <b>YOU</b>';
									else
										echo htmlentities($result["logip"]);
									?></td>
								<td><?php echo htmlentities($result["mindate"]);?></td>
								<td><?php echo htmlentities($result["maxdate"]);?></td>	
								<td style="text-align: center; background-clip: content-box;" class="<?php if ($result["failcount"]>4)
								{ echo 'table-danger'; }
								elseif ($result["failcount"]>2)
								{ echo 'table-warning'; } ?>"><?php echo $result["failcount"];?></td>	
							<td>
							<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
								<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="modIP" title="reset Fails" value="<?php echo $result["logip"];?>" onclick="return confirm('fehlgeschlagene Logins auf 0 setzen?');">
								<?php if ($result["failcount"]>4) { ?>
									<i class="fa fa-unlock" style="color:red"></i>
									<?php } else { ?>
									<i class="fa fa-pencil"></i> 
									<?php } ?></button>
								<button type="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="profile" data-toggle="modal" data-target="#<?php echo chr($cnt+97);?>" title="Detaildaten anzeigen" value="<?php echo $result["logip"];?>"><i class="fa fa-search"></i></button>
							</form>
							</td>
							</tr>
				<?php $cnt=$cnt+1; }?>		
</tbody>
</table>
</div>
<?php
$cnt=1;
foreach($results as $result) {		
	$fullString=$db->getIPInfo($result["logip"]);
		?>
		<div class="container">
		<!-- Modal -->
		<div class="modal fade" id="<?php echo chr($cnt+97);?>" role="dialog">
		  <div class="modal-dialog modal-xl">
		  
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">Details für die IP <?php echo $result["logip"];?></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body">
			  <table class="table">
			  <thead class="thead-light">
				<tr>
					<th>logdate</th>
					<th>loguser</th>
					<th>logaction</th>
					<th>logdetails</th>
				</tr>
				</thead>
				<tbody>
				<tr><td><?php foreach ($fullString as $oneString) { ?>
				<tr>
					<td><?echo implode('</td><td>',$oneString) ?></td>
				</tr>
				<?php } ?>		

</tbody>
				</table>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
			
		  </div>
		</div>
		
	  </div>
	  <?php $cnt=$cnt+1; }?>		
	</div>
</div>
</div>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("usertable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

<script>
function sortTablenum() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("usertable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (Number(x.innerHTML) > Number(y.innerHTML)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>
</div>
</div>