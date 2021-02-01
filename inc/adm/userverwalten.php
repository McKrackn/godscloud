<?php
include 'utility/admincheck.php';

?>
    <script src="res/jquery-3.5.1.min.js"></script>
    <script src="res/jquery-ui.js"></script>
	<script src="res/bootstrap.bundle.min.js"></script>

	<blockquote class="rounded-pill blockquote text-right h3">
		Wenn wir aber unsre Sünden bekennen, so ist er treu und gerecht.
		<footer class="blockquote-footer text-monospace">Johannes 1:9</footer>
	</blockquote>
		<div class="jumbotron content">
		<div class="contentborder">
		<p class="small font-weight-bold text-right text-monospace">ja, es gibt auch Schäfchen in den Wolken. und ja, sie machen genau so viel Mist.</p>
	<form class="form-inline my-2" method="POST">
        <input name="adminsearch" id="adminsearch" class="form-control mr-sm-2" type="text" placeholder="Name/E-Mail suchen" aria-label="Search">
    </form>

	<div class="row">
	<div class="col-md-12">

	<div class="panel panel-default">
	<div class="panel-body">

	<table class="display table table-striped table-bordered table-hover bg bg-light" id="usertable" cellspacing="0" width="100%">
		<thead><tr>
			<th onclick="sortTablenum(0)">#</th>
			<th onclick="sortTablenum(1)">ID</th>
			<th onclick="sortTable(2)">Username</th>
			<th onclick="sortTable(3)">Email</th>
			<th onclick="sortTable(4)">Rolle</th>
		<th>Aktion</th>	
		</tr></thead>
		<tbody id ="results">
		<?php

//Liste der nicht gelöschtern User aus der db abrufen und in Tabellenform darstellen:
    $results=$db->getUserList();
		if(!isset($_POST['adminsearch']) || strlen($_POST['adminsearch']==0)) 
		{
			$cnt=1;
			$logusername=$_SESSION['logusername'];
			foreach($results as $result) {

//Useraktionen mit Icons versehen, Sonderbehandlung für gerade angemeldeten User. Darstellung der Userdetails über Akkordeon:
		?>
							<tr style="">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result->getId());?></td>
								<td><?php if (strcasecmp($result->getUsername(),$logusername) ==0)
										echo htmlentities($result->getUsername()), '  -- <b>YOU</b>';
									else
										echo htmlentities($result->getUsername());
									?></td>
									<td><?php echo htmlentities($result->getEmail());?></td>
									<td><?php echo htmlentities($result->getRolle());?></td>	
							<td>
							<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
								<?php if (strcasecmp($result->getUsername(),$_SESSION['logusername']) ==0) { ?>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="modself" title="lasseslieber" onclick="return alert('Sich selbst zu sperren kann böse enden!');"><i class="fa fa-pencil" style="color:silver"></i></button>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="delself" title="liebernicht" onclick="return alert('Sich selbst zu löschen kann unangenehme Nebenwirkungen haben!');"><i class="fa fa-trash" style="color:silver"></i></button>
								<?php } else { ?>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="mod" title="sperren/entsperren" value="<?php echo $result->getId();?>" onclick="return confirm('User sperren/entsperren?');"><i class="fa fa-pencil"></i></button>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="del" title="löschen" value="<?php echo $result->getId();?>" onclick="return confirm('Achtung! Der User wird nur in der Datenbank als gelöscht markiert, ist dort aber noch ersichtlich.');"><i class="fa fa-trash" style="color:red"></i></button>
								<?php } ?>
								<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result->getId();?>" onclick="return confirm('User sperren/entsperren?');"><i class="fa fa-picture-o"></i></button>
								<button type="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="profile" title="Userprofil anzeigen" class="collapsed" data-toggle="collapse" data-target="#<?php echo chr($cnt+97);?>" data-parent="#results"><i class="fa fa-search"></i></button>
            </form>
							</td>
							</tr>
            <tr style="font-size: small; font-weight: bold;" id="<?php echo chr($cnt+97);?>" class="collapse" data-parent="#results">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result->getId());?></td>
            <td colspan="4"><?php echo htmlentities($result->getUsername())?>'s Details:
            <form class="form-horizontal">

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="fname">Vorname:</label>  
  <div class="col-md-2">
  <input id="fname" name="fname" type="text" value="<?php echo $result->getVorname() ?>" class="form-control input-md" disabled>
  </div>

  <label class="col-md-2 control-label" for="lname">Nachname:</label>  
  <div class="col-md-2">
  <input id="lname" name="lname" type="text" value="<?php echo $result->getNachname() ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="anrede">Geschlecht:</label>  
  <div class="col-md-2">
  <input id="anrede" name="anrede" type="text" value="<?php echo $result->getAnrede() ?>" class="form-control" disabled>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="address">Adresse:</label>  
  <div class="col-md-2">
  <input id="address" name="address" type="text" value="<?php echo $result->getAddresse() ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="plz">PLZ:</label>  
  <div class="col-md-2">
  <input id="plz" name="plz" type="text" class="form-control" value="<?php echo $result->getPlz() ?>" disabled>
  </div>

  <label class="col-md-2 control-label" for="visibility">Status:</label>  
  <div class="col-md-2">
  <input id="visibility" name="visibility" type="text" class="form-control" value="<?php echo $result->getVisibility() ?>" disabled>
  </div>
</div>

</form>
            </td>
                </tr>
							<?php $cnt=$cnt+1; }
            }
            
//AJAx-Script, dann Script zum Sortieren der Tabelle über Klick auf Header:
				?>
                <script>
                    $(document).ready(function() {
                        $("#adminsearch").keyup(function() {
							var search = $(this).val();
							var loguser = "<?php echo $_SESSION['logusername'] ?>";
							var results = <?php echo json_encode($results) ?>;
                            $.ajax({
                                url: 'inc/adm/userAJAXDetails.php',
                                method: 'post',
                                data: {
									query: search,
									logusername: loguser,
									results: results 
                                },
                                success: function(response) {
                                    $('#results').html(response);
                                }
                            });
                        });
                    });
				</script>

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
      try {
        x = rows[i].getElementsByTagName("TD")[n];
      } catch (TypeError) {
        x = 0;
      }
      try {
        y = rows[i + 1].getElementsByTagName("TD")[n];
      } catch (TypeError) {
        y = 0;
      }
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

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>