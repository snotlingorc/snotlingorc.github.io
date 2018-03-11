<?php

#######################################

# Read in the form variables
   while (list($key, $value) = each ($_POST))
   {
      #echo "have $key and $value<Br>\n";
      if ($key == "Location") {$Location = $value;}
      else if ($key == "Race") {$Race = $value;}
      else if ($key == "Age") {$Age = $value;}
      else if ($key == "Sex") {$Sex = $value;}
      else if ($key == "Career") {$Career = $value;}
    }
    
$root_dir = getcwd();
$base_dir = $root_dir."/files/".$Location;

#session_start();

####################################################################
# Main application
####################################################################
  #if no race as selected, default to Human
   if(strcmp($Race, "-1") == 0) {
         $Race = "Human";
   }

  # We will assume the character is NOT Liber Fanatica (LF) for a while
  $LF = 0;
  $LF_background = 0;
   
  # Lets first get the vitals of the character
  $character_age = get_age($Race, $Age);
  $character_sex = get_sex($Sex);
  $character_weight = get_weight($Race);
  $character_fate = get_fate($Race);
  $character_wounds = get_wounds($Race);
  $character_height = get_height($Race, $character_sex);
  $character_name = get_name($Race, $character_sex);
  $sex_check=0;
  $eye_color = get_eyecolor($Race);
  $hair_color = get_haircolor($Race);
  $hair_type = chop(random_line($base_dir."/".$Race."/hairstyle"));
  $birthplace = get_birthplace($Race);
  $star_sign = get_star();
  $marks = get_marks();
  $siblings = get_siblings($Race);

   if(strcmp($Career, "Random") == 0) {
         $Career = pick_career($Race);
   } 

   # How about a LF Random, or any LF Background
   $LFFound = substr($Career, 0, 2);
   if (strcmp($LFFound, "LF") == 0 ) {
   	$LF_background = substr($Career, 3);
      $LF=1;
      if (strcmp($LF_background, "Random") == 0) {
          $LF_background = LF_pick_background($Race);
      }
      $Career = LF_pick_career($LF_background, $Race);
   }

  # Now for the profile 
  $counter = 0;
  $lines = file($base_dir."/".$Race."/profile");
  foreach ($lines as $line_num => $line) {
    list($attrib,$what_to_roll,$what_to_add) = explode(":",$line);
    list($number_die,$sides_of_die) = explode("d",$what_to_roll);
    $attrib_value = roll_die($number_die,$sides_of_die) + $what_to_add;

    if(strcmp($attrib, "W") == 0) {
      $attrib_value = $character_wounds + $what_to_add;
    }
    if(strcmp($attrib, "SB") == 0) {
      $attrib_value = floor($attribvalue[2]/10)   ;
    }
    if(strcmp($attrib, "TB") == 0) {
      $attrib_value = floor($attribvalue[3]/10)   ;
    }
    if(strcmp($attrib, "FP") == 0) {
      $attrib_value = $character_fate   ;
    }

    $attribname[$counter] = $attrib;
    $attribvalue[$counter] = $attrib_value;
    $startervalue[$counter] = $attrib_value;
    $counter++;
  } 
  

###########################################
# Getting the Career bits
###########################################
 $career_path = $Career;
 $count = 0;
 $skillcount = 0;
 $talentcount = 0;
 $number_of_trappings = 0;
 $number_of_exits = 0;
 $attribtotal = 16;
 $talent_add = 0;
 $trappings_add = 0;
 $exp_used = 0;
 $lang = 0;
 
 #first grab the default trappings for everyone
 # Need to check if a LF style character
 
 if ($LF == 1) {
    $linest = file($base_dir."/../LiberFanatica/".$LF_background.".trappings");
 } else {
    $linest = file($base_dir."/trappings");
 }

 foreach ($linest as $line_num => $line) {
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


 $lines = file($base_dir."/career/".$Career);
 foreach ($lines as $line_num => $line) {

    if ($count < $attribtotal) {
       list($attrib, $value) = explode(":", $line);
       $attribscheme[$count] = $value;
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
       # start collecting skills
       if ($do == 1) {
          # Need to check for  OR  in the line and pick one
          $testing_for = $line;
          $OR_found = 1;
                                                                                                           
          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 $skill_list[$skillcount] = trim($testing_for);
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

          $skillcount++;
       }
       # start collecting talents
       if ($do == 2) {
          # Need to check for  OR  in the line and pick one
          $testing_for = $line;
          $OR_found = 1;
                                                                                                           
          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 $talent_list[$talentcount] = trim($testing_for);
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
       # start collecting trappings
       if ($do == 3) {
          #first grab the default trappings for everyone
          # Need to check for  OR  in the line and pick one
          $testing_for = $line;
          $OR_found = 1;

          while ($OR_found == 1) {
              $pos = strpos($testing_for, " OR ");
              if ($pos === false) {
                 $trapping_list[$number_of_trappings] = trim($testing_for);
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

          $number_of_trappings++;
       }
       if ($do == 4) {
          $exit_list[$number_of_exits] = $line;
          $number_of_exits++;
       }
    } 
 }

###########################################
# Getting the Skill bits (should be a function)
# alot of this stuff should have been functions.. oh well :-)

 #ok, now that we have the number of skills
 #some races have skills by default. lets get those first

 $lines = file($base_dir."/".$Race."/skills");
 foreach ($lines as $line_num => $line) {
    # Need to check for  OR  in the line and pick one
    $testing_for = $line;
    $OR_found = 1;

    while ($OR_found == 1) {
        $pos = strpos($testing_for, " OR ");
        if ($pos === false) {
           $skill_list[$skillcount] = trim($testing_for);
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
  

    $skillcount++;
 }

 # Now lets get the LF skills
 if ($LF == 1 ) {
    #First lets roll the number for the skill/talent table
    $LF_skill_talent_roll = rand(1, 10);
    # Check is a 10 is rolled - If it is, roll again and follow directions
    # TODO
    # for now, just roll again and pick from the same background
    if ($LF_skill_talent_roll == 10) {
       $LF_skill_talent_roll = rand(1, 9);
    }
    # Now that we have the number, consult the table
    $lines = file($base_dir."/../LiberFanatica/SkillsTalents");
    $found = 0;
    foreach ($lines as $line_num => $line) {
       if ($found < 1) {
         list($number,$skillbit,$talentbit) = explode(":", $line, 3);
         if ($LF_skill_talent_roll <= $number) { $found = 1; }
       }
    }

    # now add the right amount of skills
    for ($i = 0; $i < $skillbit; $i++) {
      $lines = file($base_dir."/../LiberFanatica/".$LF_background.".skills");
      $LF_skill_roll = rand(1,100);
      $found = 0;
      foreach ($lines as $line_num => $line) {
         if ($found < 1) {
           list($number,$skill) = explode(":", $line);
           if ($LF_skill_roll <= $number) { $found = 1; }
         }
      }
      # check for RURALSKILL or URBANSKILL
      if (strcmp(trim($skill), "RURALSKILL") == 0) {
	  $lines = file($base_dir."/../LiberFanatica/"._RURAL_.".skills");
          $LF_skill_roll = rand(1,100);
          $found = 0;
          foreach ($lines as $line_num => $line) {
             if ($found < 1) {
               list($number,$skill) = explode(":", $line);
               if ($LF_skill_roll <= $number) { $found = 1; }
             }
          }
      }
      if (strcmp(trim($skill), "URBANSKILL") == 0) {
	  $lines = file($base_dir."/../LiberFanatica/"._URBAN_.".skills");
          $LF_skill_roll = rand(1,100);
          $found = 0;
          foreach ($lines as $line_num => $line) {
             if ($found < 1) {
               list($number,$skill) = explode(":", $line);
               if ($LF_skill_roll <= $number) { $found = 1; }
             }
          }
      }
     

      $skill_list[$skillcount] = trim($skill);
      $skillcount++;
   }

 }  # END LF skills bonus

 
###########################################
# Getting the Talent bits (should be a function)

 #some races have talents by default. lets get those first

 $lines = file($base_dir."/".$Race."/talents");
 foreach ($lines as $line_num => $line) {
    #if RANDOM is found, pick one out of the random file
    if (strcmp(chop($line), "RANDOM") == 0) {
        # RANDOM and Liber Fanatica
        if ($LF == 1 ) {
          # Halflings roll for more one backgounrd skill or talnet
          #Humans roll for one background skill AND one talent.

        } else {
           $talent_list[$talentcount] = random_talent($Race);
        }
    } 
    else {
       # Need to check for  OR  in the line and pick one
       $testing_for = $line;
       $OR_found = 1;
                                                                                                           
       while ($OR_found == 1) {
           $pos = strpos($testing_for, " OR ");
           if ($pos === false) {
              $talent_list[$talentcount] = trim($testing_for);
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

    }
    $talentcount++;
 }

 # Now lets get the LF talents
 if ($LF == 1 ) {
    # now add the right amount of talents
    for ($i = 0; $i < $talentbit; $i++) {
      $lines = file($base_dir."/../LiberFanatica/".$LF_background.".talents");
      $LF_skill_roll = rand(1,100);
      $found = 0;
      foreach ($lines as $line_num => $line) {
         if ($found < 1) {
           list($number,$talent) = explode(":", $line);
           if ($LF_skill_roll <= $number) { $found = 1; }
         }
      }
      $talent_list[$talentcount] = trim($talent);
      $talentcount++;
   }
 }  # END LF talent bonus


sort($talent_list);
$temp=array_unique($talent_list);
$talent_list=array_values($temp);
$talentcount = count($talent_list);

# ok.. now that we have all the basic talents.  we need to look for
# some special cases (they increase stats)
# _COOLHEADED_ = +5 WP
# _FLEETFOOTED_ = +1 M
# _HARDY_ = +1 W
# _LIGHTNINGREFLEXES_ = +5 Ag
# _MARKSMAN_ = +5 BS
# _SAVVY_ = +5 Int
# _SUAVE_ = +5 Fel
# _VERYRESILIENT_ = +5 T
# _VERYSTRONG_ = +5 S
# _WARRIORBORN_ = +5 WS

#Initalize to 0
    for ($i = 0; $i < $attribtotal; $i++) {
      $talentbonus[$i]=0;
    } 

for ($d=0; $d<$talentcount; $d++) {
   if (strcmp($talent_list[$d], "Coolheaded") == 0) {
     $talentbonus[6] = 5;
   }
   if (strcmp($talent_list[$d], "Fleet Footed") == 0) {
     $talentbonus[12] = 1;
   }
   if (strcmp($talent_list[$d], "Hardy") == 0) {
     $talentbonus[9] = 1;
   }
   if (strcmp($talent_list[$d], "Lightning Reflexes") == 0) {
     $talentbonus[4] = 5;
   }
   if (strcmp($talent_list[$d], "Marksman") == 0) {
     $talentbonus[1] = 5;
   }
   if (strcmp($talent_list[$d], "Savvy") == 0) {
     $talentbonus[5] = 5;
   }
   if (strcmp($talent_list[$d], "Suave") == 0) {
     $talentbonus[7] = 5;
   }
   if (strcmp($talent_list[$d], "Very Resilient") == 0) {
     $talentbonus[3] = 5;
     $attribvalue[11] = floor(($attribvalue[3]+5)/10);
   }
   if (strcmp($talent_list[$d], "Very Strong") == 0) {
     $talentbonus[2] = 5;
     $attribvalue[10] = floor(($attribvalue[2]+5)/10);
   }
   if (strcmp($talent_list[$d], "Warrior Born") == 0) {
     $talentbonus[0] = 5;
   }
}


################################
#let us get number_careers and career_list
 $number_of_careers = 0;
 $lines = file($base_dir."/".$Race."/career");
 foreach ($lines as $line_num => $line) {
    list($stuff,$careerthingie) = explode(":",$line);
    $career_list[$number_of_careers] = trim($careerthingie);
    $number_of_careers++;
 }
  $tempcareer_list = implode("|",$career_list);
 
###########################################
# lets go ahead and sort the skills/talents/trappings
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

  $feet2 = $character_height / 12 ;
  $pat = ".";
  $feet = explode($pat ,$feet2);

  $inches = $character_height % 12 ;
  
  $character_height = $feet[0]." ft ".$inches." ";

echo"<th align=right valign=top>Height</th><td align=left><input type=text size=7 name=character_height value=\"".$character_height."\"></td> "
  . "<th align=right valign=top>Weight</th><td align=left><input type=text size=7 name=character_weight value=\"".$character_weight." lbs\"></td></tr> "
  . "<tr><th align=right valign=top>Star Sign</th><td align=left colspan=3><input type=text name=star_sign value=\"".$star_sign."\"></td> "
  . "<th align=right valign=top>Siblings</th><td align=left colspan=3><input type=text size=5 name=siblings value=\"".$siblings."\"></td></tr> "
  . "<tr><th align=right valign=top>Birthplace</th><td align=left colspan=3><input type=text size=35 name=birthplace value=\"".$birthplace."\"></td> "
  . "<th align=right valign=top>Marks</th><td align=left colspan=3><input type=text name=marks value=\"".$marks."\"></td></tr> "
  . "</table> ";

  echo "<input type=hidden name=character_sex value=\"".$character_sex."\">";
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
  //$tempadvancestaken = implode("|",$advancestaken);
  //echo "<input type=hidden name=tempadvancestaken value=\"".$tempadvancestaken."\">";
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
  echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
  echo "<input type=hidden name=number_of_careers value=\"".$number_of_careers."\">";
  echo "<input type=hidden name=tempcareer_list value=\"".$tempcareer_list."\">";
  echo "<input type=hidden name=career value=\"".$Career."\">";

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

echo"</tr><tr><th>Current Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      $attribbit = $attribvalue[$i] + $talentbonus[$i];
      echo "<td> $attribbit</td>";
      if ($i == ($attribtotal/2 - 1)) {echo "<td></td>"; }
    }
echo"</table> <table><tr> <th>Career Path</th></tr><tr><td>";
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
  
  $exp_used = -100;
# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

  echo "<input type=hidden name=Location value=\"".$Location."\">";
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

  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";

  # don't need
  # $_SESSION['exits'] = $exit_list;

  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
  echo "<input type=hidden name=lang value=\"".$lang."\">";
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


# let us begin the big ol' nasty form
echo "<form method=POST action=advance.php>";

  echo "<input type=hidden name=Location value=\"".$Location."\">";
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

  echo "<input type=hidden name=number_of_trappings value=\"".$number_of_trappings."\">";
  echo "<input type=hidden name=skillcount value=\"".$skillcount."\">";
  echo "<input type=hidden name=talentcount value=\"".$talentcount."\">";
  echo "<input type=hidden name=number_of_exits value=\"".$number_of_exits."\">";

  echo "<input type=hidden name=career_path value=\"".$career_path."\">";
$exp_used = $exp_used+100;
  echo "<input type=hidden name=exp_used value=\"".$exp_used."\">";
  echo "<input type=hidden name=lang value=\"".$lang."\">";
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

  echo "<center>"
  . "<br>"
  . "</font>"
 ."";

#include("todo.php");
echo '<br /><a href="index.php">Generate a new NPC</a><br>';

# Printer Friendly part

echo "<form method=POST  target=_blank action=printer.php>";

  echo "<input type=hidden name=Location value=\"".$Location."\">";
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
  echo "<input type=hidden name=lang value=\"".$lang."\">";
  echo "<input type=hidden name=LF value=\"".$LF."\">";
  echo "<input type=hidden name=LF_background value=\"".$LF_background."\">";
  echo "<input type=hidden name=birthplace value=\"".$birthplace."\">";
  echo "<input type=hidden name=star_sign value=\"".$star_sign."\">";
  echo "<input type=hidden name=marks value=\"".$marks."\">";
  echo "<input type=hidden name=siblings value=\"".$siblings."\">";
 echo "<INPUT TYPE=submit value=\"Printer Friendly\"></form>";



###########################################
###########################################
# Careers and Skills 
###########################################
###########################################
#Geting the career
###########################################
function pick_career($race) {
 global $base_dir;
 $roll_of_the_die = rand(1, 100);

 $lines = file($base_dir."/".$race."/career");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$career) = explode(":", $line);
      if ($roll_of_the_die <= $number) { $found = 1; }
    }
 }
 $career = chop($career);
 return($career);
}

###########################################
#Geting the career for LF types
###########################################
function LF_pick_career($background, $race) {
 global $base_dir;
 $roll_of_the_die = rand(1, 100);

 $lines = file($base_dir."/../LiberFanatica/".$background.".career");
 #echo "rolling for career $roll_of_the_die<br>";

 # First check for special cases in for some races
 if(((strcmp($background, "Bourgeois") == 0) || (strcmp($background, "Mercantile") == 0) || (strcmp($background, "Urban") == 0)  ) && (strcmp($race, "Elf") == 0) && (($roll_of_the_die % 20) == 0)){
     $career = "Envoy";
     return($career);
 }

 if(((strcmp($background, "Military") == 0) || (strcmp($background, "Rural") ==0 ) ) && (strcmp($race, "Halfling") == 0) && (($roll_of_the_die % 20) == 0)){
    $career = "Fieldwarden";
    return($career);
 }

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$career) = explode(":", $line);
      if ($roll_of_the_die <= $number) { $found = 1; }
    }
 }
 # check to see if the career needs to be changed, because of a background change.
 if(strcmp(trim($career), "RURALCAREER") == 0) {
   $career = LF_pick_career("Rural", $race); 
 }
 if(strcmp(trim($career), "URABANCAREER") == 0) {
   $career = LF_pick_career("Urban", $race);
 }

 $career = chop($career);
 return($career);
}

###########################################
#Geting the background for LF types
###########################################
function LF_pick_background($race) {
 global $base_dir;
 $roll_of_the_die = rand(1, 100);

 # check for racial issues.
 if((strcmp($race, "Dwarf") == 0) || (strcmp($race, "Elf" ) == 0)) {
    if (($roll_of_the_die % 10)== 0) {
       #assign the right career
       if (strcmp($race, "Dwarf") == 0) {
          $background = "Dwarf";
          return($background);
       }
       if (strcmp($race, "Elf") == 0) {
          $background = "Elf";
          return($background);
       }
    }
 }
 # otherwise keep going as normal

 $lines = file($base_dir."/../LiberFanatica/background");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$background) = explode(":", $line);
      if ($roll_of_the_die <= $number) { $found = 1; }
    }
 }
 $background = chop($background);
 return($background);
}


###########################################
# End Careers and Skills
###########################################
###########################################
 
###########################################
function random_talent($race) {
 global $base_dir;

 $lines = file($base_dir."/".$race."/talents.random");
 $number_rolled = rand(1,100);

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$ran_talent) = explode(":", $line);
      if ($number_rolled <= $number) { $found = 1; }
    }
 }
 return(chop($ran_talent));
}



###########################################
###########################################
# Vital Stats
###########################################
###########################################
#getting height
###########################################
function get_height($race, $sex) {
 global $base_dir;

 $lines = file($base_dir."/".$race."/height");
 foreach ($lines as $line_num => $line) {
   list($filesex,$diceinfo,$what_to_add) = explode(":",$line);
   if (strcmp($sex, $filesex) == 0) {
     list($number_of_dice,$sides_of_dice) = explode("d",$diceinfo);
   }
 }  
 $number_rolled = roll_die($number_of_dice,$sides_of_dice);
 $total_height = $number_rolled + $what_to_add;

 return($total_height);
}


############################################
#Getting the weight
############################################
function get_weight($race) {
 global $base_dir;
 $weight_die_roll = rand(1, 100);

 $lines = file($base_dir."/".$race."/weight");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$weight) = explode(":", $line);
      if ($weight_die_roll <= $number) { $found = 1; }
    }
 }
 return(chop($weight));
}

############################################
#Getting the eye color
############################################
function get_eyecolor($race) {
 global $base_dir;
 $eyecolor_die_roll = rand(1, 10);

 $lines = file($base_dir."/".$race."/eyecolor");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$eyecolor) = explode(":", $line);
      if ($eyecolor_die_roll <= $number) { $found = 1; }
    }
 }
 return(chop($eyecolor));
}
############################################
#Getting the hair color
############################################
function get_haircolor($race) {
 global $base_dir;
 $haircolor_die_roll = rand(1, 10);

 $lines = file($base_dir."/".$race."/haircolor");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$haircolor) = explode(":", $line);
      if ($haircolor_die_roll <= $number) { $found = 1; }
    }
 }
 return(chop($haircolor));
}

############################################
#Getting the wounds
############################################
function get_wounds($race) {
 global $base_dir;
 $wound_die_roll = rand(1, 10);

 $lines = file($base_dir."/".$race."/wounds");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$wound) = explode(":", $line);
      if ($wound_die_roll <= $number) { $found = 1; }
    }
 }
 return(chop($wound));
}

############################################
#Getting the fate points
############################################
function get_fate($race) {
 global $base_dir;
 $die = rand(1, 10);

 $lines = file($base_dir."/".$race."/fate");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$fate) = explode(":", $line);
      if ($die <= $number) { $found = 1; }
    }
 }
 return(chop($fate));
}

###########################################
#lets pick the name from lists
###########################################
function get_name($race, $sex) {
  global $base_dir;
  $lastname = chop(random_line($base_dir."/".$race."/lastname"));
  $firstname = chop(random_line($base_dir."/".$race."/".$sex.".firstname"));
  $fullname = $firstname." ".$lastname;
  return($fullname);
  
}
####################################################################
# All the little personality functions
####################################################################
function get_star() {
  global $base_dir;
  $lines = file($base_dir."/starsign");
  $dieroll = rand(1, 100);
  $found = 0;
  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
     if ($found < 1) {
       list($number,$sign) = explode(":", $line);
       if ($dieroll <= $number) { $found = 1; }
     }
  }
  return($sign);
}

function get_birthplace($Race) {
  global $base_dir;
  $lines = file($base_dir."/".$Race."/birthplace");
  $dieroll = rand(1, 100);
  $roll_on_human = 0;
  $found = 0;
  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
     if ($found < 1) {
       list($number,$birth) = explode(":", $line);
       if ($dieroll <= $number) { $found = 1; }
     }
  }
  # check for human.  if so, then rull on table 2 and cat them together
  if (strcmp($Race, "Human") == 0) {
    $lines = file($base_dir."/".$Race."/birthplace-2");
    $dieroll = rand(1, 100);
    $found = 0;
    foreach ($lines as $line_num => $line) {
       $line_array[] = $line;
         if ($found < 1) {
           list($number,$birth2) = explode(":", $line);
           if ($dieroll <= $number) { $found = 1; }
         }
    }
    $birth = trim($birth2)." in ".trim($birth);
  }
  # Check for dwarf or halfling born in human lands
  if ((strcmp($Race, "Dwarf") == 0) && (strcmp(trim($birth), "HUMAN")==0)) {
     $birth = get_birthplace("Human") ;
  }
  if ((strcmp($Race, "Halfing") == 0) && (strcmp(trim($birth), "HUMAN")==0)) {
     $birth = get_birthplace("Human") ;
  }
  return($birth);
}

function get_marks() {
  global $base_dir;
  $lines = file($base_dir."/marks");
  $dieroll = rand(1, 100);
  $found = 0;
  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
     if ($found < 1) {
       list($number,$marks) = explode(":", $line);
       if ($dieroll <= $number) { $found = 1; }
     }
  }
  return($marks);
}

function get_siblings($Race) {
  global $base_dir;
  $lines = file($base_dir."/".$Race."/siblings");
  $dieroll = rand(1, 10);
  $found = 0;
  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
     if ($found < 1) {
       list($number,$siblings) = explode(":", $line);
       if ($dieroll <= $number) { $found = 1; }
     }
  }
  return($siblings);
}

####################################################################
# Gets the age of this character
####################################################################
function get_age($race, $age) {
  global $base_dir;

 if (strcmp($age, "Young") == 0) {
    $age_die_roll = rand(1, 50);
 } elseif (strcmp($age, "Middle-Aged") == 0) {
    $age_die_roll = rand(50 ,75);
 } elseif (strcmp($age, "Old") == 0) {
    $age_die_roll = rand(75, 100);
 } else {
    $age_die_roll = rand(1, 100);
 }

  $lines = file($base_dir."/".$race."/age");

  $found = 0;
  foreach ($lines as $line_num => $line) {
     $line_array[] = $line;
     if ($found < 1) {
       list($number,$age) = explode(":", $line);
       if ($age_die_roll <= $number) { $found = 1; }
     }
  }

  return($age);
}

###########################################
# lets get the sex of the character
###########################################
function get_sex($sex) {

  if (strcmp($sex, "Random") == 0) {
     $total = rand(1, 2);
     if ($total == 2) {$sex = "Male";}
     else {$sex = "Female"; }
  }
  return($sex); 
}

###########################################
###########################################
# End Vital Stats
###########################################
###########################################

###########################################
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
     // $total = $total+$what_to_add;
  }
  else { $total = 0; }
  return($total);
}

# Pick a random line from a file (hair/eye color, etc)
function random_line($file_to_randomize) {
  global $base_dir;
  //echo "base_dir : ".$base_dir;
  //$lines = file($base_dir."/".$file_to_randomize);
  $lines = file($file_to_randomize);
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

