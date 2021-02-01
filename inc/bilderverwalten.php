<?php
$directory = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['REQUEST_URI']) . '/pictures/' . $_SESSION['logusername'] . '/';

if (is_dir($directory) === false) {
    mkdir($directory);
}
$thumbdir = $directory . 'thumbnail/';

if (is_dir($thumbdir) === false) {
    mkdir($thumbdir);
}

$weblocation = '' . dirname($_SERVER['REQUEST_URI']) . '/pictures/' . $_SESSION['logusername'] . '/';

//Bildupload:
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitpic'])) {   
    $imageFileType = strtolower(pathinfo(($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION)); 
    if (($_FILES["fileToUpload"]["name"]) != "") {

//Verzeichnisse setzen:
        $file = $_FILES["fileToUpload"]["name"];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $path_filename_ext = $directory . $filename . "." . $ext; 
        $temp_name = $_FILES['fileToUpload']['tmp_name'];
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        		$_SESSION["message"] = "Das ist kein Bild, glaube ich.";
                $_SESSION["messagetype"]="warning";
//        		echo '<div class="text-center">Das ist kein Bild, glaube ich.</div>';

    } else if (file_exists($path_filename_ext)) { 
        $_SESSION["message"] = "Datei bereits vorhanden";
		$_SESSION["messagetype"]="warning";
//  	echo '<div class="text-center">Datei bereits vorhanden!</div>';
    } else {

//File verschieben und Attribute auslesen:
        move_uploaded_file($temp_name, $path_filename_ext);         
        $exifs = exif_read_data($path_filename_ext, 0, true, true); 
        $filename = $exifs["FILE"]["FileName"];
        $filedatetime = date("Y-m-d", $exifs["FILE"]["FileDateTime"]); 
        $uploaddate = date("Y-m-d", time()); 
        $filesize = $exifs["FILE"]["FileSize"];
        $filetype = $exifs["FILE"]["FileType"];
        $mimetype = $exifs["FILE"]["MimeType"];
        $picsize = $exifs["COMPUTED"]["html"];
        $owner = $_SESSION['logusername'];

//neues Bild-Objekt erstellen
        $newPic = new Picture($filename, $filedatetime, $uploaddate, $filesize, $filetype, $mimetype, $picsize, $owner);
        
        if ($newPic != null) {
//		echo $db->insertPicture($newPic);               
		$_SESSION["message"] = "Upload erfolgreich!";
//		echo '<div class="text-center">Upload erfolgreich!</div>';
        }
            
//Thumbnail-Generation:
        $size = getimagesize($path_filename_ext); 
        $thumb_pic = imagecreatetruecolor(160, 90); 
        $orig_pic = imagecreatefromjpeg($directory . $filename); 
        imagecopyresampled($thumb_pic, $orig_pic, 0, 0, 0, 0, 160, 90, $size[0], $size[1]); 
        imagejpeg($thumb_pic, $thumbdir . $filename);
    }
//header("Location:#"); 
echo("<meta http-equiv='refresh' content='0'>"); //Refresh by HTTP 'meta'

}

?>
<blockquote class="rounded-pill blockquote text-right h3">
	Gebt, so wird euch gegeben.
  <footer class="blockquote-footer text-monospace">Lukas 6:38 </footer>
</blockquote>

<div class="jumbotron content" style="overflow-y: hidden">
<div class="contentborder" style="height: 100%">
<p class="small font-weight-bold text-right text-monospace">im Himmel sehen Bilder gleich noch viel schöner aus.</p>

<div id="uploadbox" class="col-2">
<form method="POST" enctype="multipart/form-data">
<button type="button" class="btn btn-light btn-block" onclick="document.getElementById('fileToUpload').click()">Bild auswählen...</button>
      <div class="form-group inputDnD">
        <label class="sr-only" for="fileToUpload">File Upload</label>
        <input type="file" class="form-control-file text-primary font-weight-bold" id="fileToUpload" name="fileToUpload" accept="image/*" onchange="readUrl(this)" data-title="...oder herziehen"><br>
        <button id="btn" type="submit" class="btn btn-success btn-block" name="submitpic" onclick= reloadData()>Hochladen</button>
      </div>
      </select>

</form>

<!-- <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group files">
                            <label for="fileToUpload" name="uploadLabel" id="uploadLabel">Bilder hochladen: </label>
                            <input type="file" class="form-control" id="mycustominput" multiple="" name="fileToUpload" id="fileToUpload" accept="image/x-png,image/gif,image/jpeg">
                            <button id="btn" type="submit" class="btn btn-primary" name="submit" onclick= reloadData()>Hochladen</button>
                        </div>
                    </form> -->
                </div>
                
<div id="picbox" class="col-9 offset-1" name="gallery-fancy" >
<?php
                $dir=opendir($directory);
                while(false!==$entry= readdir($dir)){
                    if($entry!=="."&&$entry!==".."&&$entry!=="thumbnail"){
                        echo("<a data-fancybox='gallery' class='fancybox' href='$weblocation$entry'><img src='$weblocation$entry' class='img-thumbnail' style='width:200px'></a>\n");
                    }
                }
                ?>
                </div>
</div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">               
                </div>
                <div class= "col-8 offset-1" name="gallery-fancy" id="picbox" style="overflow-y: scroll; height: 100%; max-height: 100%">
                    
            </div>

        </div>
        </div>
</div>
<script>
function readUrl(input) {
  
    if (input.files && input.files[0]) {
      let reader = new FileReader();
      reader.onload = (e) => {
        let imgData = e.target.result;
        let imgName = input.files[0].name;
        input.setAttribute("data-title", imgName);
        console.log(e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  
  }
</script>
<!--        <script>
            $(document).ready(function(){
                $('[data-fancybox="gallery"]').fancybox({
                    loop:true
                });
                $.fancybox.defaults.animationEffect = "zoom-in-out";
                $.fancybox.defaults.transitionEffect = "zoom-in-out";
            });
        </script>   -->

