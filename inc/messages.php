<?php
include 'utility/usercheck.php';
?>
	<div class="row">
	<div class="col-md-12">

	<div class="panel panel-default">
	<div class="panel-body">

	<table class="display table table-striped table-bordered table-hover bg bg-light" id="msgtable" cellspacing="0" width="100%">
		<thead><tr>
			<th onclick="sortMsgTablenum(0)">#</th>
			<th onclick="sortMsgTable(1)">Von</th>
			<th onclick="sortMsgTable(2)">Betreff</th>
			<th onclick="sortMsgTable(3)">Datum</th>
		<th>Aktion</th>	
		</tr></thead>
		<tbody id ="msgresults">
		<?php

//Liste der nicht gelöschtern Nachrichten aus der db abrufen und in Tabellenform darstellen:
    $msgresults=$db->getMsgList($_SESSION['actuser']->getId());
			$cnt=1;
			foreach($msgresults as $result) {

//Mailaktionen mit Icons versehen, Sonderbehandlung für ungelesene Mails. Darstellung der Details über Akkordeon:
		?>
							<tr style="<?php if ($result['status'] == 'unread') echo 'font-weight: bold;' ?>">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result['username']);?></td>
								<td><?php echo htmlentities($result['msg_subject']);?></td>
								<td><?php echo htmlentities($result['msg_timestamp']);?></td>	
							<td>
							<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
              <?php if ($result['msg_body'] == 'frq') { ?>
                <button type="submit" style="display: inline; border: none; cursor: pointer; outline: inherit" class="btn btn-success" name="frqacc" title="Anfrage annehmen" value="<?php echo $result['msg_id'];?>"><i class="fa fa-check"></i></button>
                <button type="submit" style="display: inline; border: none; cursor: pointer; outline: inherit" class="btn btn-danger" name="frqdec" title="Anfrage ablehnen" value="<?php echo $result['msg_id'];?>"><i class="fa fa-times"></i></button>
              <?php } else { ?>
                <a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="createmsg" title="antworten" data-toggle="modal" data-target="#sendMsg" onclick="document.getElementById('msgTitle').innerHTML = 'Antwort an <?php echo $result['username'];?>';document.getElementById('subject').value = 'Re: <?php echo $result['msg_subject'];?>';document.getElementById('msgBtn').value='<?php echo $result['sender_id'];?>';"><i style="color: black" class="fa fa-reply-all"></i></a>
								  <button type="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="viewmsg" title="Nachricht anzeigen" class="collapsed" onclick="<?php if($result['status']=='unread') {$db->modifyMsg($result['msg_id'],'read'); $result['status']='read';} ?>" data-toggle="collapse" data-target="#<?php echo chr($cnt+97);?>" data-parent="#msgresults"><i class="fa fa-search"></i></button>
              <?php } ?>
              <button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="delmsg" title="Nachricht löschen" value="<?php echo $result['msg_id'];?>" onclick="return confirm('Zur Hölle damit?');"><i class="fa fa-trash" style="color:red"></i></button>
            </form>
							</td>
							</tr>
            <tr style="font-size: small;" id="<?php echo chr($cnt+97);?>" class="collapse" data-parent="#msgresults">
								<td><?php echo htmlentities($cnt);?></td>
            <td colspan="4"><p style="text-decoration: underline; font-weight: bold;"><?php echo htmlentities($result['msg_subject'])?></p>
            <p><?php echo htmlentities($result['msg_body'])?></p>
            <button type="submit" style="display: inline;" class="btn btn-outline-success" name="replymsg" title="antworten" value="<?php echo $result['msg_id'];?>" onclick=""><i class="fa fa-reply"></i> Antworten</button>
            <button type="submit" style="display: inline;" class="btn btn-outline-danger" name="delmsg" title="Nachricht löschen" value="<?php echo $result['msg_id'];?>" onclick="return confirm('Zur Hölle damit?');"><i class="fa fa-trash-o"></i> Löschen</button>
            </td>
                </tr>
							<?php $cnt=$cnt+1; }
            
//Script zum Sortieren der Tabelle über Klick auf Header:
				?>
				<script>
function sortMsgTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("msgtable");
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
function sortMsgTablenum() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("msgtable");
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