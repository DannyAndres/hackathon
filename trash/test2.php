<?php
$input = "@titulo1-@+des1-+@titulo 2-@+des2-+";
$Matches = [];
preg_match("/@(.*?)-@/", $input, $Matches,0);
var_dump($Matches);