<?php

#####################################
# Add in the javascript that will change the careers
    include_once "javascript/Skaven.php";

#####################################

echo ""
  . "<p><img src=images/wfrplogo.gif><br>"
                                                                                                   
  . "Squeek-Squeek, Chitter Chitter.<p>"
  . "The Mighty and The Chosen are not working right at the moment.<br>"
  . " The snotlings are working on it. "
                                                                                                   
  . "<form method=POST action=generate.php> "
  . "<input type=hidden name=Location value=\"Skaven\">"
  . "<table border=0><tr>"
  . "<th valign=top align=right>Must Select:</th>"
  . "<td align=right valign=top>" ;
                                                                                                   
  echo "Race: <SELECT NAME=\"Race\" onChange=\"fillSelectFromArray(this.form.Career, ((this.selectedIndex == -1) ? null : career[this.selectedIndex-1]));\"> ";
  echo "<OPTION VALUE=\"-1\">Select Race " ;
  echo "<option VALUE=\"The Chosen\">The Chosen";
  echo "<option VALUE=\"The Mighty\">The Mighty";
  echo "<option VALUE=\"The Common\">The Common";

  echo "</select> <br> "
  . "<th valign=top align=right>Optional:</th>"
  . "<td align=left valign=top>"
  . "Age: <select name=\"Age\"> "
  . "<option>Random"
  . "<option>Young "
  . "<option>Middle-Aged "
  . "<option>Old "
  . "</select> <br> "
  . "Sex : <select name=\"Sex\"> "
  . "<option>Random"
  . "<option>Male"
  . "<option>Female"
  . "</select> <br> "
  . "Career: <select name=\"Career\"> "
  . "<option>Random</option> "
  . "</select> <br> "
  . "</td></tr>"
  . "<th colspan=2>Press submit to Continue</th><td>"
  . "<input type=submit>"
  . "</td></tr>"
  . "</table>"
  . "</form>"
  . "<p>"
  . "<font size=-2>Warhammer and other Warhammer Fantasy Rople Play (and the Logo's) are (probably
registered) trademarks of Games Workshop and/or Green Ronin and/or Black Industries.  The use of trademarks and materials are not meant as a challange to their rights and is not intended to make or
lose any money for anyone. "
  . "</font></center>"
 ."";

#####################################

?>
