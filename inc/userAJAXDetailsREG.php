<?php 
	$cnt=1;
	$searchString=$_POST['query'];
	$logusername=$_POST['logusername'];
	$results=$_POST['results'];
	if (strlen($searchString)>0){
		foreach($results as $result) {
		if (stripos($result["username"],$searchString) !== false || stripos($result["email"],$searchString) !== false) { ?>	
		<tr>
			<td><?php echo htmlentities($cnt);?></td>
			<td><?php if (strcasecmp($result["username"],$logusername) ==0)
					echo htmlentities($result["username"]), '  -- <b>YOU</b>';
				else
					echo htmlentities($result["username"]);
				?></td>
		<td>
		<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
			<?php if (strcasecmp($result["username"],$logusername) ==0) { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="addself" title="selbst lieben" onclick="return alert('Man sollte schon sein eigener Freund sein!');"><i class="fa fa-user-plus" style="color:silver"></i></button>
				<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="msgself" title="selbst reden" onclick="return alert('Sich selbst zu schreiben ist wie laut mit sich selbst zu reden.');"><i class="fa fa-envelope" style="color:silver"></i></a>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="blockself" title="selbst blocken" onclick="return alert('Sich selbst zu ignorieren ist auch keine Lösung.');"><i class="fa fa-ban" style="color:silver"></i></button>
			<?php } else { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="add" title="Freund hinzufügen" value="<?php echo $result["id"];?>" onclick="return confirm('Eine Freundschaftsanfrage verschicken?');"><i class="fa fa-user-plus"></i></button>
				<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="createmsg" title="Nachricht schicken" data-toggle="modal" data-target="#sendMsg" onclick="document.getElementById('msgTitle').innerHTML = 'Nachricht an <?php echo $result['username'];?>';document.getElementById('msgBtn').value='<?php echo $result['id'];?>';"><i style="color: black" class="fa fa-envelope"></i></a>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="block" title="User blocken" value="<?php echo $result["id"];?>" onclick="return confirm('Achtung! Der User wird geblockt und kann Ihnen keine Nachrichten mehr schreiben. Falls eine Freundschaft besteht, wird diese natürlich entfernt.');"><i style="color: red;" class="fa fa-ban"></i></button>
			<?php } ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result["id"];?>"><i class="fa fa-picture-o"></i></button>
		</form>
		</td>
		</tr>
		<?php $cnt=$cnt+1; } } 	; 
} else {
	foreach($results as $result) {
		?>	
		<tr>
			<td><?php echo htmlentities($cnt);?></td>
			<td><?php if (strcasecmp($result["username"],$logusername) ==0)
					echo htmlentities($result["username"]), '  -- <b>YOU</b>';
				else
					echo htmlentities($result["username"]);
		
				?></td>
		<td>
		<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
			<?php if (strcasecmp($result["username"],$logusername) ==0) { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="addself" title="selbst lieben" onclick="return alert('Man sollte schon sein eigener Freund sein!');"><i class="fa fa-user-plus" style="color:silver"></i></button>
				<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="msgself" title="selbst reden" onclick="return alert('Sich selbst zu schreiben ist wie laut mit sich selbst zu reden.');"><i class="fa fa-envelope" style="color:silver"></i></a>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="blockself" title="selbst blocken" onclick="return alert('Sich selbst zu ignorieren ist auch keine Lösung.');"><i class="fa fa-ban" style="color:silver"></i></button>
			<?php } else { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="add" title="Freund hinzufügen" value="<?php echo $result["id"];?>" onclick="return confirm('Eine Freundschaftsanfrage verschicken?');"><i class="fa fa-user-plus"></i></button>
				<a role="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="createmsg" title="Nachricht schicken" data-toggle="modal" data-target="#sendMsg" onclick="document.getElementById('msgTitle').innerHTML = 'Nachricht an <?php echo $result['username'];?>';document.getElementById('msgBtn').value='<?php echo $result['id'];?>';"><i style="color: black" class="fa fa-envelope"></i></a>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="block" title="User blocken" value="<?php echo $result["id"];?>" onclick="return confirm('Achtung! Der User wird geblockt und kann Ihnen keine Nachrichten mehr schreiben. Falls eine Freundschaft besteht, wird diese natürlich entfernt.');"><i style="color: red;" class="fa fa-ban"></i></button>
			<?php } ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result["id"];?>"><i class="fa fa-picture-o"></i></button>
		</form>
		</td>
		</tr>
		<?php $cnt=$cnt+1; } 	; 
}
  ?> 