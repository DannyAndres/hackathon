<?php
$input = "@titulo1-@+des1-+@titulo 2-@+des2-+";
$Matches = [];
preg_match("/@(.*?)-@/", $input, $Matches,0);
var_dump($Matches);


<?php if ($_POST['texto'] != '') { ?>


        <div>
          <h5><?php echo htmlspecialchars($_POST['texto']); ?></h5>
        </div>
      	<hr>