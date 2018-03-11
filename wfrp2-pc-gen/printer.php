<?php

   while (list($key, $value) = each ($_POST))
   {
      #echo "have $key and $value<Br>\n";
      if ($key == "Location") {$Location = $value;}
      else if ($key == "Race") {$Race = $value;}
      else if ($key == "character_age") {$character_age = $value;}
      else if ($key == "character_sex") {$character_sex = $value;}
      else if ($key == "character_weight") {$character_weight = $value;}
      else if ($key == "character_wounds") {$character_wounds = $value;}
      else if ($key == "character_height") {$character_height = $value;}
      else if ($key == "character_name") {$character_name = $value;}
      else if ($key == "Career") {$Career = $value;}
      else if ($key == "eye_color") {$eye_color = $value;}
      else if ($key == "hair_color") {$hair_color = $value;}
      else if ($key == "hair_type") {$hair_type = $value;}
      else if ($key == "temptrapping_list") {$temptrapping_list = $value;}
      else if ($key == "temptalent_list") {$temptalent_list = $value;}
      else if ($key == "tempskill_list") {$tempskill_list = $value;}
      else if ($key == "tempattribvalue") {$tempattribvalue = $value;}
      else if ($key == "tempstartervalue") {$tempstartervalue = $value;}
      else if ($key == "tempattribscheme") {$tempattribscheme = $value;}
      else if ($key == "attrib_total") {$attrib_total = $value;}
      else if ($key == "tempadvancestaken") {$tempadvancestaken = $value;}
      else if ($key == "temptalentbonus") {$temptalentbonus = $value;}
      else if ($key == "tempexit_list") {$tempexit_list = $value;}
      else if ($key == "number_of_trappings") {$number_of_trappings = $value;}
      else if ($key == "skillcount") {$skillcount = $value;}
      else if ($key == "talentcount") {$talentcount = $value;}
      else if ($key == "number_of_exits") {$number_of_exits = $value;}
      else if ($key == "career_path") {$career_path = $value;}
      else if ($key == "exp_used") {$exp_used = $value;}
      else if ($key == "LF") {$LF = $value;}
      else if ($key == "LF_background") {$LF_background = $value;}
      else if ($key == "birthplace") {$birthplace = $value;}
      else if ($key == "star_sign") {$star_sign = $value;}
      else if ($key == "marks") {$marks = $value;}
      else if ($key == "siblings") {$siblings = $value;}

    }




  $trapping_list = explode("|",$temptrapping_list);
  $talent_list = explode("|",$temptalent_list);
  $skill_list = explode("|",$tempskill_list);

  $attribvalue = explode("|",$tempattribvalue);
  $startervalue = explode("|",$tempstartervalue);
  $attribscheme = explode("|",$tempattribscheme);
  $advancestaken = explode("|",$tempadvancestaken);
  $talentbonus = explode("|",$temptalentbonus);
  $exit_list = explode("|",$tempexit_list);

echo '<center>Warhammer Fantasy Role Play V2 Character Sheet</center><br />';

$attribtotal=16;


###########################################
# Printing it all out
###########################################

echo"<table border=0 WIDTH=550> <tr> "
  . "<th align=right>Name :</th><td align=left>$character_name"
  . "</td> "
  . "<th align=right>Race :</th><td align=left>$Race</td></tr> "
  . "<tr><th align=right>Current Career :</th><td align=left>$Career </td>";
  if ($LF == 1) {
    echo "<th align=right>LF background :</th><td>$LF_background </td>";
  }
  echo "</tr> "
  . "</table> "
  . "<p> "
  . "<table border=1 WIDTH=550>  <tr> "
  . "<th align=right valign=top>Hair Color</th><td align=left>$hair_color"
  . "</td> "
  . "<th align=right valign=top>Eye Color</th><td align=left>$eye_color"
  . "</td> "
  . "<th align=right valign=top>Age</th><td align=left>$character_age</td> "
  . "<th align=right valign=top>Sex</th><td align=left>$character_sex</td></tr> "
  . "<tr><th align=right valign=top>Hair Type</th> "
  . "<td colspan=3 align=left>$hair_type"
  . "</td> ";

  #$feet2 = $character_height / 12 ;
  #$pat = "\.";
  #$feet = split($pat ,$feet2);
  #$inches = $character_height % 12 ;

echo"<th align=right valign=top>Height</th><td align=left>$character_height</td> "
  . "<th align=right valign=top>Weight</th><td align=left>$character_weight lbs</td></tr> "
  . "<tr><th align=right valign=top>Star Sign</th><td align=left colspan=3>$star_sign</td> "
  . "<th align=right valign=top>Siblings</th><td align=left colspan=3>$siblings</td></tr> "
  . "<tr><th align=right valign=top>Birthplace</th><td align=left colspan=3>$birthplace</td> "
  . "<th align=right valign=top>Marks</th><td align=left colspan=3>$marks</td></tr> "

  . "</table> "
  . "<p> "
  . "";

echo"<table border=1  WIDTH=550><tr>"
  . "<th></th><th colspan=8>Primary</th><th></th><th colspan=8>Secondary</th></tr>"
  . "<tr><th></th><th> WS </th><th> BS </th><th> S </th><th> T </th><th> Ag </th><th> Int </th><th> WP </th><th> Fel </th> <th></th> <th> A </th><th> W </th><th> SB </th><th> TB </th><th> M </th><th> Mag </th><th> IP </th><th> FP </th></tr>"

  . "<tr><th>Starter Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td> $startervalue[$i]</td>";
      if ($i == ($attribtotal/2 - 1)) {echo "<td></td>"; }
    }

echo"</tr><tr><td>Talent Bonus</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$talentbonus[$i]</td>";
      if ($i == ($attribtotal/2 - 1)) {echo "<td></td>"; }
    }

echo"</tr><tr><td>Adv. Scheme</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$attribscheme[$i]</td>";
      if ($i == ($attribtotal/2 - 1)) {echo "<td></td>"; }
    }

echo"</tr><tr><td>Adv. Taken</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$advancestaken[$i]</td>";
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }

echo"</tr><tr><th>Current Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      $attribbit = $attribvalue[$i] + $talentbonus[$i];
      echo "<td> $attribbit</td>";
      if ($i == ($attribtotal/2 - 1)) {echo "<td></td>"; }
    }

$new_exp=$exp_used;

if ($exp_used < 0) { $new_exp=0; }
echo"</table> <table><tr><th width=50% align=left>Career Path</th><td align=right>Experience Points:</td><td align=left>$new_exp</td></tr><tr><td colspan=3>";

echo "$career_path";
echo"</td></tr></table> "
  . "<p> "
  . "<table border=0  WIDTH=100%><tr>"
  . "<th>Skills</th><th>Talents</th><th>Trappings</th></tr> "
  . "<tr><td valign=top>"
  . "<ul>";

  $duplicate_skills = 1;
  for ($x = 0; $x < ($skillcount); $x++) {
  	if (($x+1) < $skillcount ) {
  		 
    if (strcmp(trim($skill_list[$x]), trim($skill_list[$x+1])) == 0) {
      $duplicate_skills = $duplicate_skills+1;
    } else {
      if ($duplicate_skills > 3) {$duplicate_skills = 3;}
      if ($duplicate_skills > 1) {
        echo "<li> $skill_list[$x] * $duplicate_skills";
      } else {echo "<li> $skill_list[$x]";}
      $duplicate_skills = 1;
    }
  }
  }

echo"</ul> "
  . "</td><td valign=top>"
  . "<ul>";

  $duplicate_talents = 1;
  for ($x = 0; $x < ($talentcount); $x++) {
  	if (($x+1) < $talentcount ) {
  		 
    if (strcmp(trim($talent_list[$x]), trim($talent_list[$x+1])) == 0) {
      $duplicate_talent = $duplicate_talent+1;
    } else {
      echo "<li> $talent_list[$x]";
      $duplicate_talent = 1;
    }
  }
  }
  
echo"</ul> "
  . "</td><td valign=top>"
  . "<ul>";

  $duplicate_trappings = 1;
  for ($x = 0; $x < ($number_of_trappings); $x++) {
  	if (($x+1) < $number_of_trappings ) {
  		 
    if (strcmp(trim($trapping_list[$x]), trim($trapping_list[$x+1])) == 0) {
      $duplicate_trappings = $duplicate_trappings+1;
    } else {
      echo "<li> $trapping_list[$x]";
      $duplicate_trappings = 1;
    }
  }
  }
  
#for ($x = 0; $x < $number_of_trappings; $x++)
   #{ echo "<li> $trapping_list[$x]"; }

echo"</ul> "
  . "</td></tr></table>";

echo "<b>Career Exits:</b><ul>";
for ($y = 0; $y < $number_of_exits; $y++)
   { echo "<li> $exit_list[$y]"; }

echo"</ul> "
  . "</td></tr> "
  . "</table> "
  . "<p>"
  . "<center>"
  . "<font size=2>Created by wfrp2-pc-gen v1.0"
  . "<br>"
  . "</font>"
 ."";
?>
