<?php

$base_dir = "/home/content/s/n/o/snot7031/html/whfrp/warhammer-npc-gen";

$Age = $_POST["Age"];
$Race = $_POST["Race"];
$Class = $_POST["Class"];
$Sex = $_POST["Sex"];

#$Age = "Random";
#$Race = chop(random_line("race.txt"));
#$Class = chop(random_line("class.txt"));
#$Sex = "Random";


####################################################################
# Main application
####################################################################

  # Lets first get the vitals of the character
  $character_age = get_age($Race, $Age);
  $character_sex = get_sex($Sex);
  $character_align = get_align($Race);
  $character_weight = get_weight($Race);
  $character_height = get_height($Race, $character_sex);
  $character_name = get_name($Race, $character_sex);
  $Career = pick_career($Race, $Class);
  $eye_color = chop(random_line($base_dir."/".$Race."/eyecolor"));
  $hair_color = chop(random_line($base_dir."/".$Race."/haircolor"));
  $hair_type = chop(random_line($base_dir."/".$Race."/hairstyle"));


  # Now for the profile 
  $counter = 0;
  $lines = file($base_dir."/".$Race."/profile");
  foreach ($lines as $line_num => $line) {
    list($attrib,$what_to_roll,$what_to_add) = split(":",$line);
    list($number_die,$sides_of_die) = split("d",$what_to_roll);
    $attrib_value = roll_die($number_die,$sides_of_die) + $what_to_add;

    #need to check for class restrictions and modify accordingly
    if ((strcmp($Class, "Warrior") == 0) && (strcmp($attrib, "WS") == 0) && ($atrrib_value < 30)) {
      $attrib_value = 30; 
    } 
    elseif ((strcmp($Class, "Ranger") == 0) && (strcmp($attrib, "BS") == 0) && ($atrrib_value < 30)) {
      $attrib_value = 30; 
    } 
    elseif ((strcmp($Class, "Rogue") == 0) && (strcmp($attrib, "I") == 0)) {
      if ((strcmp($Race, "Elf") == 0) && ($atrrib_value < 65)) {
          $attrib_value = 65; 
      } 
      elseif ($atrrib_value < 30) {
          $attrib_value = 30; 
      } 
    }
    elseif (strcmp($Class, "Academic") == 0) {
      if ((strcmp($attrib, "Int") == 0) && ($atrrib_value < 30)) {
          $attrib_value = 30; 
      } 
      if ((strcmp($attrib, "WP") == 0) && ($atrrib_value < 30)) {
          $attrib_value = 30; 
      } 
    }
    $attribname[$counter] = $attrib;
    $attribvalue[$counter] = $attrib_value;
    $counter++;
  } 

###########################################
# Getting the Career bits
###########################################

 $count = 0;
 $skillcount = 0;
 $number_of_trappings = 0;
 $number_of_exits = 0;
 $attribtotal = 14;

 #lets grab the default trappings for a class
 $lines = file($base_dir."/".$Class.".trapping");
 foreach ($lines as $line_num => $line) {
   $trapping_list[$number_of_trappings] = $line;
   $number_of_trappings++;
 }

 $lines = file($base_dir."/career/".$Career);
 foreach ($lines as $line_num => $line) {

    if ($count < $attribtotal) {
       list($attrib, $value) = split(":", $line);
       $attribscheme[$count] = $value;
       $count++;
    }
    elseif ($count == $attribtotal) {
       list($bleh, $skill_add) = split(":", $line);
       $do = 1;
       $count++; 
    } 
    elseif ($count == $attribtotal + $skill_add +1) {
       list($bleh, $trappings_add) = split(":", $line);
       $do = 2;
       $count++; 
    } 
    elseif ($count == $attribtotal + $skill_add + $trappings_add +2) {
       list($bleh, $exit_add) = split(":", $line);
       $do = 3;
       $count++; 
    } 
    else {
       $count++;
       if ($do == 1) {
          $skill_list[$skillcount] = $line;
          $skillcount++;
       }
       if ($do == 2) {
          $trapping_list[$number_of_trappings] = $line;
          $number_of_trappings++;
       }
       if ($do == 3) {
          $exit_list[$number_of_exits] = $line;
          $number_of_exits++;
       }
    } 
 }

###########################################
# Getting the Skill bits (should be a function)

 $count = 0;
 #first lets get the additional skills
 $found = 0;
 $lines = file($base_dir."/".$Race."/age.skill");
 foreach ($lines as $line_num => $line) {
    if ($found < 1) {
      list($number, $what_to_add) = split(":", $line);
      if ($character_age < $number) {
          $found = 1;
      }
    }
 }
 $number_of_skills = rand(1,4) + what_to_add;

 #ok, now that we have the number of skills
 #some races have skills by default. lets get those first
 if (strcmp ($Race,"Human") == 0) {
   # its a human.. no additional skills
 }
 else {
   $lines = file($base_dir."/".$Race."/skill");
   foreach ($lines as $line_num => $line) {
      list($mainskill, $skill1, $skill2, $skill3) = split(":", $line);
   }

   $skill_list[$count] = $mainskill;
   $count++;

   if (strcmp($Race, "Elf") == 0) {
     $sides_of_dice = 3;
     $total = rand(1, 3);
     if ($total < 2) { 
         $skill_list[$count] = $skill1; 
         $count++;
     }
     elseif ($total > 2) { 
         $skill_list[$count] = $skill3; 
         $count++;}
     else { 
         $skill_list[$count] = $skill2; 
         $count++;
     }
   }
   else {
     $total = rand(1,2);
     if ($total < 2) { 
         $skill_list[$count] = $skill1; 
         $count++; 
     }
     else { 
         $skill_list[$count] = $skill2; 
         $count++; 
     }
   }
   $number_of_skills--;
 } # End that if way up there
                                                                                     
 $number_of_dice = 1;
 $sides_of_dice = 100;
 $what_to_add = 0;
                                                                                     
 for ($x = 0; $x < $number_of_skills; $x++) {
   $total = rand(1,100);

   
   $lines = file($base_dir."/".$Race."/".$Class.".skill");
   $found = 0;
   foreach ($lines as $line_num => $line) {
      if ($found < 1) {
        list($number, $skill) = split(":", $line);
        if ($total < $number)
          { $skill_list[$count] = $skill; $count++; $found = 1; }
      }
   } #End foreach
 } #end for
 $skillcount = $count--;

 
###########################################

###########################################
# Printing it all out
###########################################

echo"<table border=0 WIDTH=550> <tr> "
  . "<th align=right>Name :</th><td align=left>$character_name"
  . "</td> "
  . "<th align=right>Race :</th><td align=left>$Race</td></tr> "
  . "<th align=right>Class :</th><td align=left>$Class</td> "
  . "<th align=right>Current Career :</th><td align=left>$Career"
  . "</td></tr> "
  . "<th align=right>Alignment :</th><td align=left>$character_align"
  . "</td></tr> "
  . "</table> "
  . "<p> "
  . "<table border=1 WIDTH=550>  <tr> "
  . "<th align=right valign=top>Hair Color</th><td align=left>$hair_color"
  . "</td> "
  . "<th align=right valign=top>Eye Color</th><td align=left>$eye_color"
  . "</td> "
  . "<th align=right valign=top>Age</th><td align=left>$character_age</td> "
  . "<th align=right valign=top>Sex</th><td align=left>$character_sex</td></tr> "
  . "<th align=right valign=top>Hair Type</th> "
  . "<td colspan=3 align=left>$hair_type"
  . "</td> ";

  $feet2 = $character_height / 12 ;
  $pat = "\.";
  $feet = split($pat ,$feet2);


  $inches = $character_height % 12 ;

echo"<th align=right valign=top>Height</th><td align=left>$feet[0]' $inches\"</td> "
  . "<th align=right valign=top>Weight</th><td align=left>$character_weight lbs</td> "
  . "</table> "
  . "<p> "
  . "";

echo"<table border=1  WIDTH=550><tr>"
  . "<th></th><th> M </th><th> WS </th><th> BS </th><th> S </th><th> T </th><th> W </th><th> I </th><th> A </th><th> Dex </th><th> Ld </th><th> Int </th><th> Cl </th><th> WP </th><th> Fel </th></tr>"

  . "<th>Starter Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td> $attribvalue[$i]</td>";
    }

echo"</tr><th>Advanced Scheme</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td>$attribscheme[$i]</td>";
    }

echo"</tr><th>Current Profile</th>";
    for ($i = 0; $i < $attribtotal; $i++) {
      echo "<td> $attribvalue[$i]</td>";
    }

echo"</table> "
  . "<dd><b>Fate points :</b> $attribvalue[$i]"
  . "<p> "
  . "<table border=0  WIDTH=550><tr>"
  . "<th>Skills</th><th>Trappings</th><th>Career Exits</th></tr> "
  . "<td valign=top>"
  . "<ul>";

  for ($x = 0; $x < ($skillcount); $x++)
   { echo "<li> $skill_list[$x]"; }

echo"</ul> "
  . "</td><td valign=top>"
  . "<ul>";

for ($x = 0; $x < $number_of_trappings; $x++)
   { echo "<li> $trapping_list[$x]"; }

echo"</ul> "
  . "</td><td valign=top>"
  . "<ul>";

for ($y = 0; $y < $number_of_exits; $y++)
   { echo "<li> $exit_list[$y]"; }

echo"</ul> "
  . "</td></tr> "
  . "</table> "
  . "<p>"
  . "<center>"
  . "<font size=2>Created by wh-npc v1.0"
  . "<br>"
  . "</font>"
 ."";




###########################################
###########################################
# Careers and Skills 
###########################################
###########################################
#Geting the career
###########################################
function pick_career($race, $class) {
 global $base_dir;
 $roll_of_the_die = rand(1, 100);

 $lines = file($base_dir."/".$race."/".$class.".career");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$career) = split(":", $line);
      if ($roll_of_the_die < $number) { $found = 1; }
    }
 }
 $career = chop($career);
 # If the career is a Theif or Entertainer then figure out what kind
 if (strcmp($career, "Theif") == 0) {
   $total = rand(1, 5);
   if ($total == 1) {$career = "Theif";}
   if ($total == 2) {$career = "Theif.Burglar";}
   if ($total == 3) {$career = "Theif.Clipper";}
   if ($total == 4) {$career = "Theif.Embezzler";}
   if ($total == 5) {$career = "Theif.Pickpocket";}
 }
 if (strcmp($career, "Entertainer") == 0) {
   $total = rand(1, 21);
   if ($total == 1) {$career = "Entertainer.Acrobat";}
   if ($total == 2) {$career = "Entertainer.Actor";}
   if ($total == 3) {$career = "Entertainer.AnimalAct";}
   if ($total == 4) {$career = "Entertainer.Bunko";}
   if ($total == 5) {$career = "Entertainer.Comic";}
   if ($total == 6) {$career = "Entertainer.Escapologist";}
   if ($total == 7) {$career = "Entertainer.FireEater";}
   if ($total == 8) {$career = "Entertainer.FortuneTeller";}
   if ($total == 9) {$career = "Entertainer.Hypnotist";}
   if ($total == 10) {$career = "Entertainer.Impressionist";}
   if ($total == 11) {$career = "Entertainer.Jester";}
   if ($total == 12) {$career = "Entertainer.KnifeThrower";}
   if ($total == 13) {$career = "Entertainer.Juggler";}
   if ($total == 14) {$career = "Entertainer.PavementArtist";}
   if ($total == 15) {$career = "Entertainer.Poet";}
   if ($total == 16) {$career = "Entertainer.Singer";}
   if ($total == 17) {$career = "Entertainer.Strongman";}
   if ($total == 18) {$career = "Entertainer.TightRopeWalker";}
   if ($total == 19) {$career = "Entertainer.Troubadour";}
   if ($total == 20) {$career = "Entertainer.Ventriloquist";}
   if ($total == 21) {$career = "Entertainer.Wrestler";}
 }

 return($career);
}


###########################################
# End Careers and Skills
###########################################
###########################################




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
   list($filesex,$diceinfo,$what_to_add) = split(":",$line);
   if (strcmp($sex, $filesex) == 0) {
     list($number_of_dice,$sides_of_dice) = split("d",$diceinfo);
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
      list($number,$weight) = split(":", $line);
      if ($weight_die_roll < $number) { $found = 1; }
    }
 }
 return(chop($weight));
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

###########################################
# getting the alignment
###########################################
function get_align($race) {
 global $base_dir;
 $align_die_roll = rand(1, 100); 

 $lines = file($base_dir."/".$race."/alignment");

 $found = 0;
 foreach ($lines as $line_num => $line) {
    $line_array[] = $line;
    if ($found < 1) {
      list($number,$align) = split(":", $line);
      if ($align_die_roll < $number) { $found = 1; }
    }
 }
 return(chop($align));
}


####################################################################
# Gets the age of this character
####################################################################
function get_age($race, $age) {
  global $base_dir;
  $lines = file($base_dir."/".$race."/age");

  list($young, $old) = split(":", $lines[0]);

  # If Random is picked, decide young or old
  if (strcmp($age, "Random") == 0) {
    $total = &roll_die(1, 2);
    if ($total < 2) {$age = "Young";}
    else {$age = "Old";}
  }

  if (strcmp($age, "Young") == 0) {
    list($number_of_dice, $sides_of_dice) = split("d",$young);
  }
  else {
    list($number_of_dice, $sides_of_dice) = split("d",$old);
  }
  $new_age = roll_die($number_of_dice, $sides_of_dice);
  if ($new_age < 17) {$new_age = 16; }
  return($new_age);
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
  for ($times = 0; $times < $number_of_dice; $times++) {
    $roll = rand(1, $sides_of_dice);
    $total = $total + $roll;
   }
  $total = $total+$what_to_add;
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

