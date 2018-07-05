<?php
$doelMap = "uploads/";
$doelFile = $doelMap . basename($_FILES["afbeelding"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($doelFile,PATHINFO_EXTENSION));
//check of image is een image
if(isset($_POST["upload"])) {
  $check = getimagesize($_FILES["afbeelding"]["tmp_name"]);
  if($check !== false) {
    echo "afbeelding gevonden - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "geen afbeelding gevonden";
    $uploadOk = 0;
  }
};
//upload een image
$image = $_FILES['afbeelding']['name'];

//pak de gegevens en zet ze om in variabelen
if ($_REQUEST) {
  $schrijver = $_REQUEST["schrijver"];
  $tekst = $_REQUEST["myDoc"];
  $tekst = "<img src =' " . $image . " ' width='300' height='250'><br>" . $tekst;
  $submit = $_REQUEST["plaatsen"];
  //file om gegevens in op te slaan
  $file = "artikels.txt";
  //maak een nieuw bestand met de titel als naam
  $inhoud = file_get_contents($file);
  //voeg nieuwe inhoud toe
  $inhoud = "<div class='een'>
             <h4>geschreven door: $schrijver</h4><br>$tekst\n<br>
             </div>";

  //schrijf de inhoud terug naar file
  file_put_contents($file, $inhoud);
};
 ?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>editor</title>
    <link href="editor.css" rel="stylesheet" type="text/css">
    <script src="editor.js"></script>
  </head>
  <body onload="initDoc();">

    <div class="blad">

      <div class="linkerkant">

        <div class="plaatje">

          <form name="compForm" method="post" action="editor.php" enctype="multipart/form-data" onsubmit="if(validateMode()){this.myDoc.value=oDoc.innerHTML;return true;}return false;">
            <h4>geschreven door: <input id="schrijver" type="text" name="schrijver"></h4><br>

            <input type="hidden" name="myDoc">

            <div id="toolBar1">

              <select onchange="formatDoc('formatblock',this[this.selectedIndex].value);this.selectedIndex=0;">
                <option selected>- opmaak -</option>
                <option value="h1">kop 1 &lt;h1&gt;</option>
                <option value="h2">kop 2 &lt;h2&gt;</option>
                <option value="h3">kop 3 &lt;h3&gt;</option>
                <option value="h4">kop 4 &lt;h4&gt;</option>
                <option value="h5">kop 5 &lt;h5&gt;</option>
                <option value="h6">ondertiteling &lt;h6&gt;</option>
                <option value="p">paragraaf &lt;p&gt;</option>
                <option value="pre">alinea &lt;pre&gt;</option>
              </select>
              <select onchange="formatDoc('fontname',this[this.selectedIndex].value);this.selectedIndex=0;">
                <option class="heading" selected>- lettertype -</option>
                <option>Arial</option>
                <option>Arial Black</option>
                <option>Courier New</option>
                <option>Times New Roman</option>
              </select>
              <select onchange="formatDoc('fontsize',this[this.selectedIndex].value);this.selectedIndex=0;">
                <option class="heading" selected>- size -</option>
                <option value="1">heel klein</option>
                <option value="2">beetje klein</option>
                <option value="3">normaal</option>
                <option value="4">beetje groot</option>
                <option value="5">groot</option>
                <option value="6">heel groot</option>
                <option value="7">mega groot</option>
              </select>
              <select onchange="formatDoc('forecolor',this[this.selectedIndex].value);this.selectedIndex=0;">
                <option class="heading" selected>- kleur -</option>
                <option value="red">rood</option>
                <option value="blue">blauw</option>
                <option value="green">groen</option>
                <option value="black">zwart</option>
              </select>
              <select onchange="formatDoc('backcolor',this[this.selectedIndex].value);this.selectedIndex=0;">
                <option class="heading" selected>- achtergrondkleur -</option>
                <option value="red">rood</option>
                <option value="green">groen</option>
                <option value="black">zwart</option>
              </select><br><br>

            </div>

            <div id="toolBar2">

              <img src="icons/justifyleft.jpg" class="intLink" title="Left align" onclick="formatDoc('justifyleft');">
              <img src="icons/justifycenter.jpg" class="intLink" title="Center align" onclick="formatDoc('justifycenter');">
              <img src="icons/justifyright.jpg" class="intLink" title="Right align" onclick="formatDoc('justifyright');">
              <img src="icons/numberedlist.jpg" class="intLink" title="Numbered list" onclick="formatDoc('insertorderedlist');">
              <img src="icons/dottedlist.jpg" class="intLink" title="Dotted list" onclick="formatDoc('insertunorderedlist');">
              <img src="icons/undo.jpg" class="intLink" title="Undo" onclick="formatDoc('undo');">
              <img src="icons/redo.jpg" class="intLink" title="Redo" onclick="formatDoc('redo');">
              <img src="icons/underline.jpg" class="intLink" title="Underline" onclick="formatDoc('underline');">
              <img src="icons/bold.jpg" class="intLink" title="Bold" onclick="formatDoc('bold');">
              <img src="icons/italic.jpg" class="intLink" title="Italic" onclick="formatDoc('italic');"><br><br>

            </div>

            <div id="textBox" name="textBox" contenteditable="true">

            </div><br>

            <input type="file" id="afbeelding" name="afbeelding">
            <input type="submit" value="upload image" name="upload">

            <h4 id="editMode">
              <input type="checkbox" name="switchMode" id="switchBox" onchange="setDocMode(this.checked);">
              <label for="switchBox">Show HTML</label>
            </h4>

            <button type="reset">cancel</button><br>

            <input type="submit" name="plaatsen" value="plaatsen"><br>

          </form>

        </div>

      </div>

      <div class="rechterkant">

        <form name="finalArtikel" method="post" action="blogindex.php">

          <input type="hidden" name="final">

          <div class="plaatje">
            <?php echo $inhoud; ?>
          </div>
          

        </form>

      </div>

    </div>





  </body>
</html>
