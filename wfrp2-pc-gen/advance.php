<?php

$tempattrib_total = 0;
$talent_add = 0;
$trappings_add = 0;

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
      else if ($key == "number_of_careers") {$number_of_careers = $value;}
      else if ($key == "tempcareer_list") {$tempcareer_list = $value;}
      else if ($key == "career") {$career = $value;}

    }
    
$root_dir = getcwd();
$base_dir = $root_dir."/files/".$Location;

#session_start();

####################################################################


echo "Location: $Location <br>";

####################################################################
# Main application
####################################################################

$Career = $career;

  $trapping_list = explode("|",$temptrapping_list);
  $talent_list = explode("|",$temptalent_list);
  $skill_list = explode("|",$tempskill_list);

  $attribvalue = explode("|",$tempattribvalue);
  $startervalue = explode("|",$tempstartervalue);
  $attribscheme = explode("|",$tempattribscheme);
  $attrib_total = explode("|",$tempattrib_total);
  $advancestaken = explode("|",$tempadvancestaken);
  $talentbonus = explode("|",$temptalentbonus);
  $career_list = explode("|",$tempcareer_list);



  $career_path = $career_path . " - " . $Career;

###########################################
# Getting the Career bits
###########################################

 $attribtotal = 16;
# Advancing the stats  
for ($i = 0; $i < $attribtotal; $i++) {
   #Add to the advances taken function
   if ($attribscheme[$i] > 0) {
      if ($i < $attribtotal/2) {
        $new_padvances = $attribscheme[$i] - ($advancestaken[$i]*5);
        if ($new_padvances <= 0) { $new_padvances = 0;}
        else {
           $advancestaken[$i] = $advancestaken[$i] + ($new_padvances/5);
           $attribvalue[$i] = $startervalue[$i] + $attribscheme[$i] + $talentbonus[$i];
           $exp_used = $exp_used + (100*$new_padvances/5);
        }
      } else {
        $new_advances = $attribscheme[$i] - $advancestaken[$i];
        if ($new_advances <= 0) { $new_advances = 0;}
        else {
           $advancestaken[$i] = $advancestaken[$i] + $new_advances;
           $attribvalue[$i] = $startervalue[$i] + $attribscheme[$i] + $talentbonus[$i];
           $exp_used = $exp_used + (100*$new_advances);
        }
      }
   }
}

 # don't forget to add 100exp for taking a new level
 $exp_used = $exp_used + 100;
 $count = 0;
 $number_of_exits = 0;

 $lines = file($base_dir."/career/".$Career);
 foreach ($lines as $line_num => $line) {

    if ($count < $attribtotal) {
       list($attrib, $value) = explode(":", $line);
       $attribscheme[$count] = $value;
       if(strcmp($attrib, "SB") == 0) {
           $startervalue[10] = floor($startervalue[2]/10)   ;
           $attribvalue[10] = floor($attribvalue[2]/10)   ;
       }
       if(strcmp($attrib, "TB") == 0) {
          $startervalue[11] = floor($startervalue[3]/10)   ;
          $attribvalue[11] = floor($attribvalue[3]/10)   ;
       }
       $count++; 
    }
    elseif ($count == $attribtotal) {
       list($bleh, $skill_add) = explode(":", $line);
       $do = 1;
       $count++; 
    } 
    elseif ($count == $attribtotal + $skill_add +1) {
       list($bleh, $talent_add) = explode(":", $line);
       $do = 2;
       $count++; 
    } 
    elseif ($count == $attribtotal + $skill_add + $talent_add +2) {
       list($bleh, $trappings_add) = explode(":", $line);
       $do = 3;
       $count++; 
    } 
    elseif ($count == $attribtotal + $skill_add + $talent_add + $trappings_add +3) {
       list($bleh, $exit_add) = explode(":", $line);
       $do = 4;
       $count++; 
    } 
    else {
       $count++;
       if ($do == 1) {
          # Need to check for  OR  in the line and pick one
          $testing_for = $line;
          $OR_found = 1;
          $found_skill=0;
                                                                                                           
          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 # lets look up the skills and see if they already 
                 # have it (or max of 3)
                 # echo "looking for $testing_for in ";
                 for ($i = 0; $i < $skillcount; $i++) {
                    #echo "$skill_list[$i] <br>";
                    if(strcmp(trim($testing_for), trim($skill_list[$i])) == 0) {
                        $found_skill = $found_skill + 1;
                    }
                 }
                 if ($found_skill > 2) {
                    $found_skill = 0;
                    $OR_found = 0;
                 } else {
                    $skill_list[$skillcount] = trim($testing_for);
                    # echo "Adding skill: $testing_for 100 exp (found $found_skill)<br>";
                    $exp_used = $exp_used + 100;
                    $found_skill = 0;
                    $OR_found = 0;
                 }
              } else {
                 list($part1,$part2) = explode(" OR ", $testing_for, 2);
                 $choice = rand(1,2);
                 if ($choice ==1) {
                     $testing_for = trim($part1);
                 } else {
                     $testing_for = trim($part2);
                 }
              }
          }


          $skillcount++;
       }
       if ($do == 2) {
          # Need to check for  OR  in the line and pick one
          $testing_for = trim($line);
          $OR_found = 1;
          $talent_exists = 0;

          $talentcount = count($talent_list);
          
          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 # now is a good time to look up the existing talents
                 # and only add new ones (this way we can track exp)
                 #echo "looking for $testing_for in ";
                 for ($i = 0; $i < $talentcount; $i++) {
                    #echo " $talent_list[$i]<br>"; 
                    if(strcmp($testing_for, $talent_list[$i]) == 0) {
                      # talent found do not add it to the list
                      $talent_exists = 1;
                    }
                 }
                 if ($talent_exists == 0) {
                     $talent_list[$talentcount] = $testing_for;
                     #echo "Adding talent: $testing_for 100 exp<br>";
                     $exp_used = $exp_used + 100;
                     #add it to the  talentbonus array
   if (strcmp($testing_for, "Coolheader") == 0) {
     $talentbonus[6] = 5;
     $attribvalue[6] = $attribvalue[6]+5;
   }
   if (strcmp($testing_for, "Fleet Footed") == 0) {
     $talentbonus[12] = 1;
     $attribvalue[12] = $attribvalue[12]+1;
   }
   if (strcmp($testing_for, "Hardy") == 0) {
     $talentbonus[9] = 1;
     $attribvalue[9] = $attribvalue[9]+1;
   }
   if (strcmp($testing_for, "Lightning Reflexes") == 0) {
     $talentbonus[4] = 5;
     $attribvalue[4] = $attribvalue[4]+5;
   }
   if (strcmp($testing_for, "Marksman") == 0) {
     $talentbonus[1] = 5;
     $attribvalue[1] = $attribvalue[1]+5;
   }
   if (strcmp($testing_for, "Savvy") == 0) {
     $talentbonus[5] = 5;
     $attribvalue[5] = $attribvalue[5]+5;
   }
   if (strcmp($testing_for, "Suave") == 0) {
     $talentbonus[7] = 5;
     $attribvalue[7] = $attribvalue[7]+5;
   }
   if (strcmp($testing_for, "Very Resilient") == 0) {
     $talentbonus[3] = 5;
     $attribvalue[3] = $attribvalue[3]+5;
     $attribvalue[11] = floor(($attribvalue[3]+5)/10);
   }
   if (strcmp($testing_for, "Very Strong") == 0) {
     $talentbonus[2] = 5;
     $attribvalue[2] = $attribvalue[2]+5;
     $attribvalue[10] = floor(($attribvalue[2]+5)/10);
   }
   if (strcmp($testing_for, "Warrior Born") == 0) {
     $talentbonus[0] = 5;
     $attribvalue[0] = $attribvalue[0]+5;
   }

                 }
                 $OR_found = 0;
              } else {
                 list($part1,$part2) = explode(" OR ", $testing_for, 2);
                 $choice = rand(1,2);
                 if ($choice ==1) {
                     $testing_for = trim($part1);
                 } else {
                     $testing_for = trim($part2);
                 }
              }
          }

          $talentcount++;
       }
       if ($do == 3) {
          # Need to check for  OR  in the line and pick one
          $testing_for = $line;
          $OR_found = 1;
                                                                                                           
          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 $trapping_list[$number_of_trappings] = $testing_for;
                 $OR_found = 0;
              } else {
                 list($part1,$part2) = explode(" OR ", $testing_for, 2);
                 $choice = rand(1,2);
                 if ($choice ==1) {
                     $testing_for = $part1;
                 } else {
                     $testing_for = $part2;
                 }
              }
          }

          $number_of_trappings++;
       }
       if ($do == 4) {
          $exit_list[$number_of_exits] = $line;
          $number_of_exits++;
       }
    } 
 }



###########################################
# lets go ahead and sort the skills/talents/trappings
sort($talent_list);
sort($skill_list);
sort($trapping_list);

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
  echo "<input type=hidden name=career value=\"".$Career."\">";
  
  echo "<input type=hidden name=Location value=\"".$Location."\">";
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
//  echo "<input type=hidden name=lang value=\"".$lang."\">";
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
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }

echo"</tr><tr><td>Talent Bonus</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$talentbonus[$i]</td>";
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }
echo"</tr><tr><td>Adv. Scheme.</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$attribscheme[$i]</td>";
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }
echo"</tr><tr><td>Adv. Taken</td>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$advancestaken[$i]</td>";
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }

echo"</tr><tr><th>Current Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td> $attribvalue[$i]</td>";
      if ($i == ($attribtotal/2 -1)) { echo "<td></td>"; }
    }

echo"</table> <table><tr><th width=50% align=left>Career Path</th><td align=right>Experience Points:</td><td align=left>$exp_used</td></tr><tr><td colspan=3>";
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

  $talentcount = count ($talent_list);
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
# comments above and uncomment below if you want to see ALL trappings
#for ($x = 0; $x < $number_of_trappings; $x++)
   #{ echo "<li> $trapping_list[$x]"; }

echo"</ul> "
  . "</td></tr>"
  . "</table>";
  
# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

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

  # don't need
  # $_SESSION['exits'] = $exit_list;

  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
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


 echo "<b>Career Exits</b><ul>";

 echo "<select name=\"career\">";
for ($y = 0; $y < $number_of_exits; $y++) {
   $exit_value = ereg_replace(" ", "_", $exit_list[$y]);
   echo "<option>$exit_list[$y]</option> "; }

  echo "</select>";

  echo "<INPUT TYPE=submit value=\"Advance Career\"></form>";

###########
# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

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
//  echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
 echo "<INPUT TYPE=submit value=\"Printer Friendly\"></form>";


#######################################

###########################################
# Helper Functions
###########################################
####################################################################
# these 2 functions help with random stuff.  The first one rolls
# dice, the second picks a line a random from a file.
####################################################################

# This will roll a die and get a random number for that die size
function roll_die($number_of_dice, $sides_of_dice) {
  global $base_dir;
  $total = 0;
  if ($number_of_dice > 0) {
     for ($times = 0; $times < $number_of_dice; $times++) {
       $roll = rand(1, $sides_of_dice);
       $total = $total + $roll;
      }
     $total = $total+$what_to_add;
  }
  else { $total = 0; }
  return($total);
}

# Pick a random line from a file (hair/eye color, etc)
function random_line($file_to_randomize) {

  $lines = file($base_dir."/".$file_to_randomize);

  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
  }

  $line_to_return = rand(0, $line_num);

  return($line_array[$line_to_return]);
}
###########################################
###########################################
# End Helper Functions
###########################################
####################################################################

?>


