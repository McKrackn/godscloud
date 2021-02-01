<?php
include 'utility/usercheck.php';
?>
	<div class="row">
	<div class="col-md-12">

	<div class="panel panel-default">
	<div class="panel-body">

	<table class="display table table-striped table-bordered table-hover bg bg-light" id="friendstable" cellspacing="0" width="100%">
		<thead><tr>
			<th onclick="sortFriendsTablenum(0)">#</th>
			<th onclick="sortFriendsTable(1)">Username</th>
      <th onclick="sortFriendsTable(2)">Status</th>
		<th>Aktion</th>	
		</tr></thead>
		<tbody id ="results">
		<?php

//Liste der nicht gelöschten Freunde aus der db abrufen und in Tabellenform darstellen:
    $results=$db->getFriendsUserList($_SESSION['actuser']->getId());
		{
			$cnt=1;
			foreach($results as $result) {

//Useraktionen mit Icons versehen:
		?>
							<tr style="">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result->getUsername());?></td>
              <td><?php if($result->getVisibility() == 'invisible') { ?>
                        <button name="visbutton" class="btn btn-warning btn-block" type="button" title="nicht verfügbar">nicht verfügbar</button>
                    <?php } elseif($result->getVisibility() == 'away') { ?>
                        <button name="visbutton" class="btn btn-warning btn-block" type="button" title="nicht verfügbar">nicht verfügbar</button>
                    <?php } elseif($result->getVisibility() == 'visible2friends') { ?>
                        <button name="visbutton" class="btn btn-outline-success btn-block" type="button" title="sichtbar (Freunde)"><small>sichtbar (Freunde)</small></button>
                    <?php } elseif($result->getVisibility() == 'visible') { ?>
                        <button name="visbutton" class="btn btn-success btn-block" type="button" title="sichtbar">sichtbar</button>
                    <?php }?>
              </td>
							<td>
							<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="unfriend" title="Freund entfernen" value="<?php echo $result->getId();?>" onclick="return confirm('Die Freundschaft wirklich kündigen?');"><i class="fa fa-user-times"></i></button>
									<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="createmsg" title="Nachricht schicken" data-toggle="modal" data-target="#sendMsg" onclick="document.getElementById('msgTitle').innerHTML = 'Nachricht an <?php echo $result->getUsername();?>';document.getElementById('msgBtn').value='<?php echo $result->getId();?>';"><i style="color: black" class="fa fa-envelope"></i></a>
									<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="block" title="User blocken" value="<?php echo $result->getId();?>" onclick="return confirm('Achtung! Der User wird geblockt und kann Ihnen keine Nachrichten mehr schreiben. Die Freundschaft wird natürlich entfernt.');"><i style="color: red;" class="fa fa-ban"></i></button>
                </form>
							</td>
							</tr>
							<?php $cnt=$cnt+1; }
            }
            
//Script zum Sortieren der Tabelle über Klick auf Header:
				?>
				<script>
function sortFriendsTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("friendstable");
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
function sortFriendsTablenum() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("friendstable");
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