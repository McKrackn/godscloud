<?php 
	$cnt=1;
	$searchString=$_POST['query'];
	$logusername=$_POST['logusername'];
	$results=$_POST['results'];
	if (strlen($searchString)>0){
		foreach($results as $result) {
		if (stripos($result["username"],$searchString) !== false || stripos($result["email"],$searchString) !== false)	 {
		?>	
		<tr>
			<td><?php echo htmlentities($cnt);?></td>
			<td><?php echo htmlentities($result["id"]);?></td>
			<td><?php if (strcasecmp($result["username"],$logusername) ==0)
					echo htmlentities($result["username"]), '  -- <b>YOU</b>';
				else
					echo htmlentities($result["username"]);
		
				?></td>
				<td><?php echo htmlentities($result["email"]);?></td>
				<td><?php echo htmlentities($result["rolle"]);?></td>	
		<td>
		<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
			<?php if (strcasecmp($result["username"],$logusername) ==0) { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="modself" title="lasseslieber" onclick="return alert('Sich selbst zu sperren kann böse enden!');"><i class="fa fa-pencil" style="color:silver"></i></button>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="delself" title="liebernicht" onclick="return alert('Sich selbst zu löschen kann unangenehme Nebenwirkungen haben!');"><i class="fa fa-trash" style="color:silver"></i></button>
			<?php } else { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="mod" title="sperren/entsperren" value="<?php echo $result["id"];?>" onclick="return confirm('User sperren/entsperren?');"><i class="fa fa-pencil"></i></button>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="del" title="löschen" value="<?php echo $result["id"];?>" onclick="return confirm('Achtung! Der User wird nur in der Datenbank als gelöscht markiert, ist dort aber noch ersichtlich.');"><i class="fa fa-trash" style="color:red"></i></button>
			<?php } ?>
			<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result["id"];?>" onclick="return confirm('zu den Userbildern wechseln?');"><i class="fa fa-picture-o"></i></button>
			<button type="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="profile" title="Userprofil anzeigen" class="collapsed" data-toggle="collapse" data-target="#<?php echo chr($cnt+97);?>" data-parent="#results"><i class="fa fa-search"></i></button>
		</form>
		</td>
		</tr>
		<tr style="font-size: small; font-weight: bold;" id="<?php echo chr($cnt+97);?>" class="collapse" data-parent="#results">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result["id"]);?></td>
            <td colspan="4"><?php echo htmlentities($result["username"])?>'s Details:
            <form class="form-horizontal">

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="fname">Vorname:</label>  
  <div class="col-md-2">
  <input id="fname" name="fname" type="text" value="<?php echo $result["vorname"] ?>" class="form-control input-md" disabled>
  </div>

  <label class="col-md-2 control-label" for="lname">Nachname:</label>  
  <div class="col-md-2">
  <input id="lname" name="lname" type="text" value="<?php echo $result["nachname"] ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="anrede">Geschlecht:</label>  
  <div class="col-md-2">
  <input id="anrede" name="anrede" type="text" value="<?php echo $result["anrede"] ?>" class="form-control" disabled>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="address">Adresse:</label>  
  <div class="col-md-2">
  <input id="address" name="address" type="text" value="<?php echo $result["addresse"] ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="plz">PLZ:</label>  
  <div class="col-md-2">
  <input id="plz" name="plz" type="text" class="form-control" value="<?php echo $result["plz"] ?>" disabled>
  </div>

  <label class="col-md-2 control-label" for="visibility">Status:</label>  
  <div class="col-md-2">
  <input id="visibility" name="visibility" type="text" class="form-control" value="<?php echo $result["visibility"] ?>" disabled>
  </div>
</div>

</div>
</form>
            </td>
                </tr>
		<?php $cnt=$cnt+1; } } 	; 
} else {
	foreach($results as $result) {
		?>	
		<tr>
			<td><?php echo htmlentities($cnt);?></td>
			<td><?php echo htmlentities($result["id"]);?></td>
			<td><?php if (strcasecmp($result["username"],$logusername) ==0)
					echo htmlentities($result["username"]), '  -- <b>YOU</b>';
				else
					echo htmlentities($result["username"]);
				?></td>
				<td><?php echo htmlentities($result["email"]);?></td>
				<td><?php echo htmlentities($result["rolle"]);?></td>	
		<td>
		<form style="display: inline; border: none; padding: 0; background: none; cursor: pointer; outline: inherit" method="POST">
		<?php if (strcasecmp($result["username"],$logusername) ==0) { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="modself" title="lasseslieber" onclick="return alert('Sich selbst zu sperren kann böse enden!');"><i class="fa fa-pencil" style="color:silver"></i></button>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="delself" title="liebernicht" onclick="return alert('Sich selbst zu löschen kann unangenehme Nebenwirkungen haben!');"><i class="fa fa-trash" style="color:silver"></i></button>
			<?php } else { ?>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="mod" title="sperren/entsperren" value="<?php echo $result["id"];?>" onclick="return confirm('User sperren/entsperren?');"><i class="fa fa-pencil"></i></button>
				<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="del" title="löschen" value="<?php echo $result["id"];?>" onclick="return confirm('Achtung! Der User wird nur in der Datenbank als gelöscht markiert, ist dort aber noch ersichtlich.');"><i class="fa fa-trash" style="color:red"></i></button>
			<?php } ?>
			<button type="submit" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="show" title="Bilder anzeigen" value="<?php echo $result["id"];?>" onclick="return confirm('zu den Userbildern wechseln?');"><i class="fa fa-picture-o"></i></button>
			<button type="button" style="display: inline; border: none; padding-right: 1em; background: none; cursor: pointer; outline: inherit" name="profile" title="Userprofil anzeigen" class="collapsed" data-toggle="collapse" data-target="#<?php echo chr($cnt+97);?>" data-parent="#results"><i class="fa fa-search"></i></button>
		</form>
		</td>
		</tr>
		<tr style="font-size: small; font-weight: bold;" id="<?php echo chr($cnt+97);?>" class="collapse" data-parent="#results">
								<td><?php echo htmlentities($cnt);?></td>
								<td><?php echo htmlentities($result["id"]);?></td>
            <td colspan="4"><?php echo htmlentities($result["username"])?>'s Details:
            <form class="form-horizontal">

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="fname">Vorname:</label>  
  <div class="col-md-2">
  <input id="fname" name="fname" type="text" value="<?php echo $result["vorname"] ?>" class="form-control input-md" disabled>
  </div>

  <label class="col-md-2 control-label" for="lname">Nachname:</label>  
  <div class="col-md-2">
  <input id="lname" name="lname" type="text" value="<?php echo $result["nachname"] ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="anrede">Geschlecht:</label>  
  <div class="col-md-2">
  <input id="anrede" name="anrede" type="text" value="<?php echo $result["anrede"] ?>" class="form-control" disabled>
  </div>
</div>

<div class="form-group row">
  <label class="col-md-2 col-form-label control-label" for="address">Adresse:</label>  
  <div class="col-md-2">
  <input id="address" name="address" type="text" value="<?php echo $result["addresse"] ?>" class="form-control" disabled>
  </div>

  <label class="col-md-2 control-label" for="plz">PLZ:</label>  
  <div class="col-md-2">
  <input id="plz" name="plz" type="text" class="form-control" value="<?php echo $result["plz"] ?>" disabled>
  </div>

  <label class="col-md-2 control-label" for="visibility">Status:</label>  
  <div class="col-md-2">
  <input id="visibility" name="visibility" type="text" class="form-control" value="<?php echo $result["visibility"] ?>" disabled>
  </div>
</div>

</div>
</form>
            </td>
        </tr>
		<?php $cnt=$cnt+1; } 	; 
}
  ?> 