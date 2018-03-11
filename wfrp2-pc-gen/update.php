<?php

# some presets because generate my not send them.
$tempadvancestaken = 0;
$character_wounds = 0;

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
      else if ($key == "tempattribscheme") {$tempattribscheme = $value;}
      else if ($key == "tempstartervalue") {$tempstartervalue = $value;}
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
      else if ($key == "number_of_careers") {$number_of_careers = $value;}
      else if ($key == "tempcareer_list") {$tempcareer_list = $value;}
      else if ($key == "career") {$career = $value;}

    }

 $root_dir = getcwd();
 $base_dir = $root_dir."/files/".$Location;
    
####################################################################

echo "Location: $Location <br>";

####################################################################
# Main application
####################################################################
 $attribtotal = 16;

  $Career = $career;

  $trapping_list = explode("|",$temptrapping_list);
  $talent_list = explode("|",$temptalent_list);
  $skill_list = explode("|",$tempskill_list);

  $attribvalue = explode("|",$tempattribvalue);
  $startervalue = explode("|",$tempstartervalue);
  $attribscheme = explode("|",$tempattribscheme);
  $advancestaken = explode("|",$tempadvancestaken);
  $talentbonus = explode("|",$temptalentbonus);
  $career_list = explode("|",$tempcareer_list);
  $exit_list = explode("|",$tempexit_list);




###########################################
# Printing it all out
###########################################

echo "<form method=POST action=update.php>";

echo"<table border=0 WIDTH=550> <tr> "
  . "<th align=right>Name :</th><td align=left> <input type=text name=character_name value=\"".$character_name."\"> </td> "
  . "<th align=right>Race :</th><td align=left>$Race</td></tr> "
  . "<tr><th align=right>Current Career :</th><td align=left>$Career</td>";
  if ($LF == 1) {
    echo "<th align=right>LF background :</th><td>$LF_background </td>"; 
  }
  echo "</tr> "
  . "</table> "
  . "<p> "
  . "<table border=1 WIDTH=550>  <tr> "
  . "<th align=right valign=top>Hair Color</th><td align=left><input type=text name=hair_color value=\"".$hair_color."\">"
  . "</td> "
  . "<th align=right valign=top>Eye Color</th><td align=left><input size=10 type=text name=eye_color value=\"".$eye_color."\">"
  . "</td> "
  . "<th align=right valign=top>Age</th><td align=left><input type=text size=5  name=character_age value=\"".$character_age."\"></td> "
  . "<th align=right valign=top>Sex</th><td align=left>$character_sex</td></tr> "
  . "<tr><th align=right valign=top>Hair Type</th> "
  . "<td colspan=3 align=left><input type=text name=hair_type value=\"".$hair_type."\">"
  . "</td> ";

echo"<th align=right valign=top>Height</th><td align=left><input type=text size=7 name=character_height value=\"".$character_height."\"></td> "
  . "<th align=right valign=top>Weight</th><td align=left><input type=text size=7 name=character_weight value=\"".$character_weight."\"></td></tr> "
  . "<tr><th align=right valign=top>Star Sign</th><td align=left colspan=3><input type=text name=star_sign value=\"".$star_sign."\"></td> "
  . "<th align=right valign=top>Siblings</th><td align=left colspan=3><input type=text size=5 name=siblings value=\"".$siblings."\"></td></tr> "
  . "<tr><th align=right valign=top>Birthplace</th><td align=left colspan=3><input type=text size=35 name=birthplace value=\"".$birthplace."\"></td> "
  . "<th align=right valign=top>Marks</th><td align=left colspan=3><input type=text name=marks value=\"".$marks."\"></td></tr> "
  . "</table> ";

  echo "<input type=hidden name=character_sex value=\"".$character_sex."\">";
  echo "<input type=hidden name=location value=\"".$Location."\">";
  echo "<input type=hidden name=Location value=\"".$Location."\">";
  echo "<input type=hidden name=career value=\"".$Career."\">";
  

  echo "<input type=hidden name=Race value=\"".$Race."\">";
  $temptrapping_list = implode("|",$trapping_list);
  echo "<input type=hidden name=temptrapping_list value=\"".$temptrapping_list."\">";
  $temptalent_list = implode("|",$talent_list);
  echo "<input type=hidden name=temptalent_list value=\"".$temptalent_list."\">";
  $tempskill_list = implode("|",$skill_list);
  echo "<input type=hidden name=tempskill_list value=\"".$tempskill_list."\">";

  $tempattribvalue = implode("|",$attribvalue);
  echo "<input type=hidden name=tempattribvalue value=\"".$tempattribvalue."\">";
  $tempstartervalue = implode("|",$startervalue);
  echo "<input type=hidden name=tempstartervalue value=\"".$tempstartervalue."\">";
  $tempattribscheme = implode("|",$attribscheme);
  echo "<input type=hidden name=tempattribscheme value=\"".$tempattribscheme."\">";
  echo "<input type=hidden name=attribtotal value=\"".$attribtotal."\">";
  $tempadvancestaken = implode("|",$advancestaken);
  echo "<input type=hidden name=tempadvancestaken value=\"".$tempadvancestaken."\">";
  $temptalentbonus = implode("|",$talentbonus);
  echo "<input type=hidden name=temptalentbonus value=\"".$temptalentbonus."\">";
  $tempexit_list = implode("|",$exit_list);
  echo "<input type=hidden name=tempexit_list value=\"".$tempexit_list."\">";

  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";
  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
 // echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
  echo "<input type=hidden name=number_of_careers value=\"".$number_of_careers."\">";
  echo "<input type=hidden name=tempcareer_list value=\"".$tempcareer_list."\">";

  echo "<INPUT TYPE=submit value=\"Change Information\"></form>"
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
      #set advances taken to 0 for career change
      $advancestaken[$i] = 0;
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
  . "<table border=0  WIDTH=550><tr>"
  . "<th>Skills</th><th>Talents</th><th>Trappings</th></tr> "
  . "<tr><td valign=top>"
  . "<ul>";

#  for ($x = 0; $x < ($skillcount); $x++)
#   { echo "<li> $skill_list[$x]"; }

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

#  for ($x = 0; $x < ($talentcount); $x++)
#   { echo "<li> $talent_list[$x]"; }


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

for ($x = 0; $x < $number_of_trappings; $x++)
   { echo "<li> $trapping_list[$x]"; }

echo"</ul> "
  . "</td></tr>"
  . "</table>";
  
# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

  echo "<input type=hidden name=location value=\"".$Location."\">";
  echo "<input type=hidden name=Location value=\"".$Location."\">";
  echo "<input type=hidden name=career value=\"".$Career."\">";
  
  echo "<input type=hidden name=Race value=\"".$Race."\">";
  echo "<input type=hidden name=character_age value=\"".$character_age."\">";
  echo "<input type=hidden name=character_sex value=\"".$character_sex."\">";
  echo "<input type=hidden name=character_weight value=\"".$character_weight."\">";
  echo "<input type=hidden name=character_wounds value=\"".$character_wounds."\">";
  echo "<input type=hidden name=character_height value=\"".$character_height."\">";
  echo "<input type=hidden name=character_name value=\"".$character_name."\">";
  echo "<input type=hidden name=Career value=\"".$Career."\">";
  echo "<input type=hidden name=eye_color value=\"".$eye_color."\">";
  echo "<input type=hidden name=hair_color value=\"".$hair_color."\">";
  echo "<input type=hidden name=hair_type value=\"".$hair_type."\">";

  $temptrapping_list = implode("|",$trapping_list);
  echo "<input type=hidden name=temptrapping_list value=\"".$temptrapping_list."\">";
  $temptalent_list = implode("|",$talent_list);
  echo "<input type=hidden name=temptalent_list value=\"".$temptalent_list."\">";
  $tempskill_list = implode("|",$skill_list);
  echo "<input type=hidden name=tempskill_list value=\"".$tempskill_list."\">";

  $tempattribvalue = implode("|",$attribvalue);
  echo "<input type=hidden name=tempattribvalue value=\"".$tempattribvalue."\">";
  $tempstartervalue = implode("|",$startervalue);
  echo "<input type=hidden name=tempstartervalue value=\"".$tempstartervalue."\">";
  $tempattribscheme = implode("|",$attribscheme);
  echo "<input type=hidden name=tempattribscheme value=\"".$tempattribscheme."\">";
  echo "<input type=hidden name=attribtotal value=\"".$attribtotal."\">";
  $tempadvancestaken = implode("|",$advancestaken);
  echo "<input type=hidden name=tempadvancestaken value=\"".$tempadvancestaken."\">";
  $temptalentbonus = implode("|",$talentbonus);
  echo "<input type=hidden name=temptalentbonus value=\"".$temptalentbonus."\">";
  $tempexit_list = implode("|",$exit_list);
  echo "<input type=hidden name=tempexit_list value=\"".$tempexit_list."\">";


  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";

  # don't need
  # $_SESSION['exits'] = $exit_list;

  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
 // echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
  echo "<input type=hidden name=number_of_careers value=\"".$number_of_careers."\">";
  echo "<input type=hidden name=tempcareer_list value=\"".$tempcareer_list."\">";

 echo "<b>Career Exits</b><ul>";

 echo "<select name=\"career\">";
for ($y = 0; $y < $number_of_exits; $y++) {
   $exit_value = ereg_replace(" ", "_", $exit_list[$y]);
   echo "<option>$exit_list[$y]</option> "; }

  echo "</select>";

  echo "<INPUT TYPE=submit value=\"Advance Career\"></form>";


###############
# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

  echo "<input type=hidden name=location value=\"".$Location."\">";
  echo "<input type=hidden name=Location value=\"".$Location."\">";
  echo "<input type=hidden name=career value=\"".$Career."\">";
  echo "<input type=hidden name=Race value=\"".$Race."\">";
  echo "<input type=hidden name=character_age value=\"".$character_age."\">";
  echo "<input type=hidden name=character_sex value=\"".$character_sex."\">";
  echo "<input type=hidden name=character_weight value=\"".$character_weight."\">";
  echo "<input type=hidden name=character_wounds value=\"".$character_wounds."\">";
  echo "<input type=hidden name=character_height value=\"".$character_height."\">";
  echo "<input type=hidden name=character_name value=\"".$character_name."\">";
  echo "<input type=hidden name=Career value=\"".$Career."\">";
  echo "<input type=hidden name=eye_color value=\"".$eye_color."\">";
  echo "<input type=hidden name=hair_color value=\"".$hair_color."\">";
  echo "<input type=hidden name=hair_type value=\"".$hair_type."\">";

  $temptrapping_list = implode("|",$trapping_list);
  echo "<input type=hidden name=temptrapping_list value=\"".$temptrapping_list."\">";
  $temptalent_list = implode("|",$talent_list);
  echo "<input type=hidden name=temptalent_list value=\"".$temptalent_list."\">";
  $tempskill_list = implode("|",$skill_list);
  echo "<input type=hidden name=tempskill_list value=\"".$tempskill_list."\">";

  $tempattribvalue = implode("|",$attribvalue);
  echo "<input type=hidden name=tempattribvalue value=\"".$tempattribvalue."\">";
  $tempstartervalue = implode("|",$startervalue);
  echo "<input type=hidden name=tempstartervalue value=\"".$tempstartervalue."\">";
  $tempattribscheme = implode("|",$attribscheme);
  echo "<input type=hidden name=tempattribscheme value=\"".$tempattribscheme."\">";
  echo "<input type=hidden name=attribtotal value=\"".$attribtotal."\">";
  $tempadvancestaken = implode("|",$advancestaken);
  echo "<input type=hidden name=tempadvancestaken value=\"".$tempadvancestaken."\">";
  $temptalentbonus = implode("|",$talentbonus);
  echo "<input type=hidden name=temptalentbonus value=\"".$temptalentbonus."\">";
  $tempexit_list = implode("|",$exit_list);
  echo "<input type=hidden name=tempexit_list value=\"".$tempexit_list."\">";

  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";

  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
  $exp_used = $exp_used + 100;
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
//  echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
  echo "<input type=hidden name=number_of_careers value=\"".$number_of_careers."\">";
  echo "<input type=hidden name=tempcareer_list value=\"".$tempcareer_list."\">";

 echo "</ul><b>Other Career Exits (200 exp)</b><ul>";

# need to build the a list based on the race.

 echo "<select name=\"career\">";
for ($y = 0; $y < $number_of_careers; $y++) {
   $exit_value = ereg_replace(" ", "_", $exit_list[$y]);
   echo "<option>$career_list[$y]</option> "; }

  echo "</select>";

  echo "<INPUT TYPE=submit value=\"Start New Career\"></form>";


#include("todo.php");
echo '<br /><a href="index.php">Generate a new NPC</a><br>';

# Printer Friendly part


echo "<form method=POST target=_blank action=printer.php>";

  echo "<input type=hidden name=location value=\"".$Location."\">";
  echo "<input type=hidden name=Location value=\"".$Location."\">";
  echo "<input type=hidden name=career value=\"".$Career."\">";
  echo "<input type=hidden name=Race value=\"".$Race."\">";
  echo "<input type=hidden name=character_age value=\"".$character_age."\">";
  echo "<input type=hidden name=character_sex value=\"".$character_sex."\">";
  echo "<input type=hidden name=character_weight value=\"".$character_weight."\">";
  echo "<input type=hidden name=character_wounds value=\"".$character_wounds."\">";
  echo "<input type=hidden name=character_height value=\"".$character_height."\">";
  echo "<input type=hidden name=character_name value=\"".$character_name."\">";
  echo "<input type=hidden name=Career value=\"".$Career."\">";
  echo "<input type=hidden name=eye_color value=\"".$eye_color."\">";
  echo "<input type=hidden name=hair_color value=\"".$hair_color."\">";
  echo "<input type=hidden name=hair_type value=\"".$hair_type."\">";

  $temptrapping_list = implode("|",$trapping_list);
  echo "<input type=hidden name=temptrapping_list value=\"".$temptrapping_list."\">";
  $temptalent_list = implode("|",$talent_list);
  echo "<input type=hidden name=temptalent_list value=\"".$temptalent_list."\">";
  $tempskill_list = implode("|",$skill_list);
  echo "<input type=hidden name=tempskill_list value=\"".$tempskill_list."\">";

  $tempattribvalue = implode("|",$attribvalue);
  echo "<input type=hidden name=tempattribvalue value=\"".$tempattribvalue."\">";
  $tempstartervalue = implode("|",$startervalue);
  echo "<input type=hidden name=tempstartervalue value=\"".$tempstartervalue."\">";
  $tempattribscheme = implode("|",$attribscheme);
  echo "<input type=hidden name=tempattribscheme value=\"".$tempattribscheme."\">";
  echo "<input type=hidden name=attrib_total value=\"".$attribtotal."\">";
  $tempadvancestaken = implode("|",$advancestaken);
  echo "<input type=hidden name=tempadvancestaken value=\"".$tempadvancestaken."\">";
  $temptalentbonus = implode("|",$talentbonus);
  echo "<input type=hidden name=temptalentbonus value=\"".$temptalentbonus."\">";
  $tempexit_list = implode("|",$exit_list);
  echo "<input type=hidden name=tempexit_list value=\"".$tempexit_list."\">";


  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";
  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
 // echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
 echo "<INPUT TYPE=submit value=\"Printer Friendly\"></form>";

#######################################

?>


