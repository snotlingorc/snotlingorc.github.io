#!/usr/local/gnu/bin/perl
###########################################################
# NPC Generator                  Version 1.0              #
# Copyright 1997 Mathew Anderson mathew@kaos.com          #
# Created : 10/26/1997           Last Modified 10/18/1997 #
###########################################################      
print "Content-type: text/html\n\n";
print "<title>WH-NPC : Warhammer NPC generator Version 1.0</title>\n";
print "<body bgcolor=#B0B0B0 background=backgd.gif>\n";
require "ctime.pl"; 
srand(time|$$);

###########################################################
# This is the secion that you should change.
# Please make sure all the information is correct
###########################################################

$dir_location = "/graphics/www/htdocs/rpg/wh-npc";
$host_name = "orion.unm.edu";
$web_loc = "rpg/wh-npc";
$name = "create2.cgi";


# Change nothing below this line
#######################################################
# Default stuff I put in all web perl programs
# This gets the data and makes it perlified
# check that POST method is used
#######################################################
if ($ENV{'REQUEST_METHOD'} eq 'POST') {
   # POST method dictates that we get the form
   # input from standard input

   # Get the input
   read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

   # Split the name-value pairs
   @pairs = split(/&/, $buffer);

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
      # Un-Webify plus signs and %-encoding
      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # Uncomment for debugging purposes
      # print "Setting $name to $value<P>";

      $FORM{$name} = $value;                               
   }
} else { &display_form; } 

if($FORM{class})
  { &gather_info; }
else {}

###########################################################################
# Now that the BS is done with form inputs, lets print out the option page
# Main from that you see, when running the program
###########################################################################
sub display_form {
print "Welcome to WH-NPC.  WH-NPC is a Warhammer NPC (or player)";
print "Character Generator.  This program follows the rules in the";
print "Warhammer Fantasy Role Play Rule Book.\n";
print "<form method=POST action=http://$host_name/$web_loc/$name> \n";
print "<table border=0><tr>\n";
print "<th valign=top align=right>Must Select:</th><td align=right>\n";
print "Class: <select name=\"class\"> \n";
#getting a list of classes...I could have just hardcoded these...
open(FILE, "$dir_location/class.txt") ||
    die print "<h2>could not open : $dir_location/class.txt</h2>";
  while (<FILE>) {
    chop();
    print "<option> $_ \n";
   }
close(FILE);                      
print "</select> <br> \n";

print "Race: <select name=\"race\"> \n";
#same thing for this part. It could have been hardcoded..
open(FILE, "$dir_location/race.txt") ||
    die print "<h2>could not open : $dir_location/race.txt</h2>";
  while (<FILE>) {
    chop();
    print "<option> $_ \n";
   }
close(FILE);
print "</select> <br> \n";
print "</td><th rowspan=2><img height=180 width=280 src=wfrplogo.gif></th></tr>\n";
print "<th valign=top align=right>Optional:</th><td align=right>\n";
print "Age: <select name=\"age\"> \n";
print "<option>Random \n";
print "<option>Young \n";
print "<option>Old \n";
print "</select> <br> \n";
print "Sex : <select name=\"sex\"> \n";
print "<option>Random \n";
print "<option>Male \n";
print "<option>Female \n";
print "</select> <br> \n";
print "</td></tr>\n";
print "<th>Press submit<br>to Continue</th><td>\n";
print "<input type=submit>\n </td></tr>\n</table>\n</form>\n";
print "Any Comments/Questions can be mail to the author : ";
print "<a href=mailto:tetsuos\@unm.edu>tetsuos\@unm.edu</a>\n";
print "<p>\n <p>\n";
print "To see what is new in the next version, select this ";
print "<a href=nextversion.html>link</a>.\n</body>";

}


####################################################################
#ok main form is done.  Now, when "submit" is pressed, We
#need to gather up the information.
####################################################################
sub gather_info {
$race = $FORM{race};
$class = $FORM{class};

$counter = 0;
# get Profile Need to roll the dice and make sure the character fits
open(FILE, "$dir_location/$race/profile") ||
    die print "<h2>could not open : $dir_location/$race/profile</h2>";
  while (<FILE>) {
    chop();
    ($attrib,$what_to_roll,$what_to_add) = split(/:/);
    ($number_of_dice,$sides_of_dice) = split(/d/,$what_to_roll);
    &roll_die;

    #check for class restrictions and modify
     if (($class eq "Warrior") && ($attrib eq "WS") && ($total < 30))
         { $total = 30; }
     elsif (($class eq "Ranger") && ($attrib eq "BS") && ($total < 30))
         { $total = 30; }
     elsif (($class eq "Rogue") && ($attrib eq "I")) {
            if (($race eq "Elf") && ($total < 65))
              { $total = 65; }
            elsif ($total < 30)
              { $total = 30; }
         }
     elsif ($class eq "Academic") {
           if (($attrib eq "Int") && ($total < 30))
             { $total = 30; }
           if (($atrrib eq "WP") && ($total > 30))
             { $total = 30; }
         }
    $attribname[$count] = $attrib; 
    $attribvalue[$count] = $total;
    $count++;
   }
$fatepoints = $attribvalue[$count-1];
$attribtotal = $count-1;
close(FILE);

#just getting the rest of the stuff in varables...
$what_to_add = 0;
&get_age;
&sex;
&get_name;
&get_height;
&get_weight;
&get_align;
#######################
#  need to get $align  and $weight
#######################
#lets get hair/eyes
$file_to_random = "$race/eyecolor";
&random_line;
$eyecolor = $result;
$file_to_random = "$race/haircolor";
&random_line;
$haircolor = $result;
$file_to_random = "$race/hairstyle";
&random_line;
$hairstyle = $result;
&career;
&skill;
# lets get the career information and the correct trappings
$number_of_trappings = 0;
&get_career_info;
&get_trappings;
&Print_it;
}


#############################################
# Now to print it all out
# Need to find a nice way of laying out the
# information
#############################################
sub Print_it {
print "<table border=0 WIDTH=550> <tr> \n";
print "<th align=right>Name :</th><td align=left>$firstname $lastname</td> \n";
print "<th align=right>Race :</th><td align=left>$race</td></tr> \n";
print "<th align=right>Class :</th><td align=left>$class</td> \n";
print "<th align=right>Current Career :</th><td align=left>$career</td></tr> \n";
print "<th align=right>Alignment :</th><td align=left>$align</td></tr> \n";
print "</table> \n";
print "<p> \n";

print "<table border=1 WIDTH=550>  <tr> \n";
print "<th align=right valign=top>Hair Color</th><td align=left>$haircolor</td> \n";
print "<th align=right valign=top>Eye Color</th><td align=left>$eyecolor</td> \n";
print "<th align=right valign=top>Age</th><td align=left>$age</td> \n";
print "<th align=right valign=top>Sex</th><td align=left>$sex</td></tr> \n";
 
print "<th align=right valign=top>Hair Type</th> \n";
print "<td colspan=3 align=left>$hairstyle</td> \n";
print "<th align=right valign=top>Height</th><td align=left>$height inches</td> \n";
print "<th align=right valign=top>Weight</th><td align=left>$weight lbs</td> \n";
print "</table> \n";
print "<p> \n";

#now lews print out the attribs nicely
print "<table border=1  WIDTH=550><tr>\n<th></th>";
for ($x = 0; $x < $attribtotal; $x++)
  { print "<th> $attribname[$x] </th>"; }
print "</tr>\n<th>Starter Profile</th>";
for ($x = 0; $x < $attribtotal; $x++)
   { print "<td> $attribvalue[$x] </td>"; }
print  "</tr>\n<th>Advanced Scheme</th>";
for ($x = 0; $x < $attribtotal; $x++)
   { print "<td> $attribscheme[$x] </td>"; }
print  "</tr>\n<th>Current Profile</th>";

for ($x = 0; $x < $attribtotal; $x++)
    {$attribcurrent[$x] = $attribvalue[$x];}
for ($x = 0; $x < $attribtotal; $x++)
    { print "<td> $attribcurrent[$x] </td>"; }
print "</table> \n";

#this part is ugly..need to find a better layout
print "<dd><b>Fate points :</b> $fatepoints\n";
print "<p> \n";
print "<table border=0  WIDTH=550><tr>\n";

#lets print out the skills - Need to sort and fix dups
print "<th>Skills</th><th>Trappings</th><th>Career Exits</th></tr> \n";
print "<td valign=top>\n<ul>\n";
for ($x = 0; $x < ($skillcount); $x++)
   { print "<li> $skill_list[$x]"; }
print "</ul> \n";

print "</td><td valign=top>\n<ul>\n";
for ($x = 0; $x < ($number_of_trappings); $x++)
   { print "<li> $trapping_list[$x]"; }
print "</ul> \n";

print "</td><td valign=top>\n<ul>\n";
for ($x = 0; $x < ($number_of_exits); $x++)
   { print "<li> $exit_list[$x]"; }
print "</ul> \n";

print "</td></tr> \n";
print "</table> \n";

#now print out my footer
print "<p>\n<center>\n";
print "<font size=2>Created by wh-npc v1.0\n<br>\n";
print "</font>\n";
print "</body> </html> ";
}


###########################################
#getting the career information for the career
###########################################
sub get_career_info {
 $file_to_open = $career;

 $num = 0;
 $do = 0;
 $count = 0;
 open(FILE, "$dir_location/career/$file_to_open") ||
    die print "<h2> could not open : career/$file_to_open</h2>";
 while (<FILE>) {
  chop();
  if ($count < $attribtotal) {
     ($attrib,$value) = split(/:/); 
     $attribscheme[$count] = $value;
     $count++;
  }
  elsif ($count == $attribtotal ) {
    ($bleh,$skill_add) = split(/:/);
    $do = 1; $count++;
    }
  elsif ($count == ($attribtotal + $skill_add +1) ) {
    ($bleh,$trappings_add) = split(/:/);
    $do = 2; $count++;
    }
  elsif ($count == ($attribtotal + $skill_add + $trappings_add +2) ) {
    ($bleh,$number_of_exits) = split(/:/);
     $do = 3; $count++;
     }
  else {
    $count++;
    if ($do == 1) {
      $skill_list[$skillcount] = "$_";
      $skillcount++;
    }
    elsif ($do == 2) {
      $trapping_list[$number_of_trappings] = $_; 
      $number_of_trappings++;
    }
    elsif ($do = 3) {
      $exit_list[$num] = $_;
      $num++; 
    }
  } # End else
 } # End whil
  close(FILE);
  
}


###########################################
#Now need to get the basic trappings
###########################################
sub get_trappings {
open(FILE, "$dir_location/$class.trapping") ||
   die print "<h2> could not open : $class.trapping</h2>";
 while (<FILE>) {
   chop();
   $trapping_list[$number_of_trappings] = $_;
   $number_of_trappings++;
 }
}

###########################################
#getting height
###########################################
sub get_height {
 open(FILE, "$dir_location/$race/height") ||
     die print "<h2>could not open : $race/height</h2>";
 while (<FILE>) {
    chop();
    ($sex1,$diceinfo,$what_to_add) = split(/:/);
    ($number_of_dice,$sides_of_dice) = split(/d/,$diceinfo);
    if ($sex eq $sex1) {&roll_die; $height = $total; }
 }
 close(FILE);
}

############################################
#Getting the weight
############################################
sub get_weight {
 $number_of_dice = 1;
 $sides_of_dice = 100;
 $what_to_add = 0;
 &roll_die;
 open(FILE, "$dir_location/$race/weight") ||
     die print "<h2>could not open : $race/weight</h2>";
 $found = 0;
 while(<FILE>) {
    chop();
    if ($found < 1) {
      ($number,$weight) = split(/:/);
      if ($total < $number) { $found = 1; }
    }
  } # End while
close(FILE);
}                             

 

###########################################
#lets pick the name from lists
###########################################
sub get_name {
  $file_to_random = "$race/lastname";
  &random_line;
  $lastname = $result;
  $file_to_random = "$race/$sex.firstname"; 
  &random_line;
  $firstname = $result;

}

###########################################
# lets get the sex of the character
###########################################
sub sex {
  if ($FORM{sex} eq "Random") {
     $number_of_dice = 1;
     $sides_of_dice = 2;
     $what_to_add = 0;
     &roll_die;
     if ($total == 2) {$sex = "Male";}
     else {$sex = "Female"; }
    }
  elsif ($FORM{sex} eq "Male") {$sex = "Male";}
  elsif  ($FORM{sex} eq "Female") {$sex = "Female";}
}



###########################################
# Pick career
###########################################
sub career {
 $number_of_dice = 1;
 $sides_of_dice = 100;
 $what_to_add = 0;
 &roll_die; 
 open(FILE, "$dir_location/$race/$class.career") ||
    die print "<h2>could not open : $race/$class.career</h2>";
  $found = 0;
  while (<FILE>) {
    chop();
    if ($found < 1) {
      ($number,$career) = split(/:/); 
      if ($total < $number) { $found = 1; }
    }
  } # End while
close(FILE);

# need to check if career is Theif or Entertainer
if ($career eq "Theif") {
  $number_of_dice = 1;
  $sides_of_dice = 5;
  $what_to_add = 0; 
  &roll_die;
  if ($total == 1) {$career = "Theif";}
  if ($total == 2) {$career = "Theif.Burglar";}
  if ($total == 3) {$career = "Theif.Clipper";}
  if ($total == 4) {$career = "Theif.Embezzler";}
  if ($total == 5) {$career = "Theif.Pickpocket";}
}
if ($career eq "Entertainer") {
  $number_of_dice = 1;
  $sides_of_dice = 21;
  $what_to_add = 0;
  &roll_die;
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

} #End career

###########################################
# getting the alignment
###########################################
sub get_align {
 $number_of_dice = 1;
 $sides_of_dice = 100;
 $what_to_add = 0;
 &roll_die;
 open(FILE, "$dir_location/$race/alignment") ||
    die print "<h2>could not open : $race/alignment</h2>";
  $found = 0;
  while (<FILE>) {
    chop();
    if ($found < 1) {
      ($number,$align) = split(/:/);
      if ($total < $number) { $found = 1; }
    }
  } # End while
close(FILE);
}

###########################################
# get the age of this character
###########################################
sub get_age {
 $age = $FORM{age};
 open(FILE, "$dir_location/$race/age") ||
    die print "<h2>could not open : $race/age</h2>";
  while (<FILE>) {
    chop();
    ($young, $old) = split(/:/);
  }
  close(FILE);
 $what_to_add = 0;
 if ($age eq "Random") {
    $number_of_dice = 1;
    $sides_of_dice = 2;
    &roll_die;
    if ($total < 2) {$age = "Young";}
    else {$age = "Old";}
   }

 if ($age eq "Young") {
    ($number_of_dice, $sides_of_dice) = split(/d/,$young);
    &roll_die;
   }
 else {
   ($number_of_dice, $sides_of_dice) = split(/d/,$old);
   &roll_die;
   }
  $age = $total;
  if ($age < 17) {$age = 16; }
  
}


#########################################################
#  This function gets the skills and counts them up
#########################################################

#pick skills
sub skill {
 $count=0;
 #first lets get the number of skills
 $number_of_dice = 1;
 $sides_of_dice = 4;
 open(FILE, "$dir_location/$race/age.skill") ||
   die print "<h2> could not open : $race/age.skill</h2>";
 $found =0;
 while (<FILE>) {
   chop();
   if ($found < 1) {
     ($number,$what_to_add) = split(/:/);
     if ($total < $number)
         { $found = 1; }
    } 
 }
 close(FILE);
 &roll_die;
 $number_of_skills = $total;

 #ok, now that we have the number of skills
 #some races have skills by default. lets get those
 if ($race ne "Human") {
   open(FILE, "$dir_location/$race/skill") ||
     die print "<h2>Cannot open : $race/skill</h2>";
   while (<FILE>) {
    chop();
    ($mainskill, $skill1, $skill2, $skill3) = split(/:/);
   }
   close(FILE);

   $skill_list[$count] = $mainskill;
   $count++;

   $what_to_add =0;
   $number_of_dice = 1;
   if ($race eq "Elf") {
     $sides_of_dice = 3;
     &roll_die;
     if ($total < 2) { $skill_list[$count] = $skill1; $count++;}
     elsif ($total > 2) { $skill_list[$count] = $skill3; $count++;}
     else { $skill_list[$count] = $skill2; $count++;}
    }
    else {
     $sides_of_dice = 2;
     &roll_die;
     if ($total < 2) { $skill_list[$count] = $skill1; $count++; }
     else { $skill_list[$count] = $skill2; $count++; }
    } 
   $number_of_skills--;
 } # End that if way up there

 $number_of_dice = 1;
 $sides_of_dice = 100;
 $what_to_add = 0;

 for ($x = 0; $x < $number_of_skills; $x++) {
   &roll_die;

   open(FILE, "$dir_location/$race/$class.skill") ||
      die print "<h2>could not open : $race/$class.skill</h2>";
   $found = 0;
   while (<FILE>) {
      chop();
      if ($found < 1)
       {
        ($number,$skill) = split(/:/);
        if ($total < $number)
          { $skill_list[$count] = $skill; $count++; $found = 1; }
       }
    } #End while
    close(FILE);
  } #end for
  $skillcount = $count--;
} #end sub




####################################################################
# these 2 functions help with random stuff.  The first one rolls
# dice, the second picks a line a random from a file.
####################################################################

# This will roll a die and get a random number for that die size
sub roll_die {
  $total = 0;
  for ($times = 0; $times < $number_of_dice; $times++) {
    $roll = int(rand($sides_of_dice)) +1;
    $total = $total + $roll;
   }
  $total = $total+$what_to_add;
  return($total);
}                                                         


# Pick a ramom line in a file (hair color/style etc)
sub random_line {
  $i = 0;
  open(STUFF,"< $dir_location/$file_to_random") || 
      die print "<h2>Couldn't open $file_to_random</h2>";

  while (<STUFF>) {
        chop();
        $random_line{$i}="$_";
        $i++;
        }
  close(STUFF);

  $number_of_arguments = $i;
  $r = (rand($number_of_arguments) % $number_of_arguments);
  $result = $random_line{$r};
}
