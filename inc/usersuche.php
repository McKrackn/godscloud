<?php

?>
  <script src="res/jquery-3.5.1.min.js"></script>
  <script src="res/jquery-ui.js"></script>
	<script src="res/bootstrap.bundle.min.js"></script>

	<form class="form-inline my-2" method="POST">
    <input name="usersearch" id="usersearch" class="form-control mr-sm-2" type="text" placeholder="nach Username suchen" aria-label="Search">
  </form>

	<div class="row">
	<div class="col-md-12">

	<div class="panel panel-default">
	<div class="panel-body">

	<table class="display table table-striped table-bordered table-hover bg bg-light" id="usertable" cellspacing="0" width="100%">
		<thead><tr>
			<th onclick="sortTablenum(0)">#</th>
			<th onclick="sortTable(1)">Username</th>
		<th>Aktion</th>	
		</tr></thead>
		<tbody id ="results">
		<?php

//Liste der nicht gelöschtern und sichtbaren User aus der db abrufen und in Tabellenform darstellen:
    $results=$db->getVisUserList();
		if(!isset($_POST['usersearch'])) 
		{
			$cnt=1;
			$logusername=$_SESSION['logusername'];
			foreach($results as $result) {

//Useraktionen mit Icons versehen, Sonderbehandlung für gerade angemeldeten User. Darstellung der Userdetails über Akkordeon:
		?>
							<tr style="">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php if (strcasecmp($result->getUsername(),$logusername) ==0)
										echo htmlentities($result->getUsername()), '  -- <b>YOU</b>';
									else
										echo htmlentities($result->getUsername());
									?></td>
							<td>
							<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
								<?php if (strcasecmp($result->getUsername(),$_SESSION['logusername']) ==0) { ?>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="addself" title="selbst lieben" onclick="return alert('Man sollte schon sein eigener Freund sein!');"><i class="fa fa-user-plus" style="color:silver"></i></button>
									<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="msgself" title="selbst reden" onclick="return alert('Sich selbst zu schreiben ist wie laut mit sich selbst zu reden.');"><i class="fa fa-envelope" style="color:silver"></i></a>
                  <button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="blockself" title="selbst blocken" onclick="return alert('Sich selbst zu ignorieren ist auch keine Lösung.');"><i class="fa fa-ban" style="color:silver"></i></button>
								<?php } else { ?>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="add" title="Freund hinzufügen" value="<?php echo $result->getId();?>" onclick="return confirm('Eine Freundschaftsanfrage verschicken?');"><i class="fa fa-user-plus"></i></button>
									<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="createmsg" title="Nachricht schicken" data-toggle="modal" data-target="#sendMsg" onclick="document.getElementById('msgTitle').innerHTML = 'Nachricht an <?php echo $result->getUsername();?>';document.getElementById('msgBtn').value='<?php echo $result->getId();?>';"><i style="color: black" class="fa fa-envelope"></i></a>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="block" title="User blocken" value="<?php echo $result->getId();?>" onclick="return confirm('Achtung! Der User wird geblockt und kann Ihnen keine Nachrichten mehr schreiben. Falls eine Freundschaft besteht, wird diese natürlich entfernt.');"><i style="color: red;" class="fa fa-ban"></i></button>
								<?php } ?>
								<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result->getId();?>" onclick="return confirm('User sperren/entsperren?');"><i class="fa fa-picture-o"></i></button>
            </form>
							</td>
							</tr>
							<?php $cnt=$cnt+1; }
            }
            
				?>

</tbody>
</table>


</div>
</div>
</div>
</div>


<script>
//AJAx-Script, dann Script zum Sortieren der Tabelle über Klick auf Header:
              $(document).ready(function() {
                        $("#usersearch").keyup(function() {
							var search = $(this).val();
							var loguser = "<?php echo $_SESSION['logusername'] ?>";
							var results = <?php echo json_encode($results) ?>;
                            $.ajax({
                                url: 'inc/userAJAXDetailsREG.php',
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