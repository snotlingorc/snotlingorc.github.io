<?php

#####################################
echo ""
  . "<p><img src=images/wfrplogo.gif><br>"
                                                                                                   
  . "Welcome Citizen of Bretonnia!<p>"
                                                                                                   
  . "<form method=POST action=generate.php> "
  . "<input type=hidden name=Location value=\"Bretonnia\">"
  . "<table border=0><tr>"
  . "<th valign=top align=right>Must Select:</th>"
  . "<td align=right valign=top>" ;

  # echo "Race: <SELECT NAME=\"Race\" onChange=\"fillSelectFromArray(this.form.Career, ((this.selectedIndex == -1) ? null : career[this.selectedIndex-1]));\"> ";
  echo "Race: <SELECT NAME=\"Race\"> ";
  echo "<OPTION VALUE=\"-1\">Select Race " ;
  echo "<option VALUE=\"Human\"> Human";
                                                                                                   
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
  . "<option>Agitator</option> "
  . "<option>Bailiff</option> "
  . "<option>Barber-Surgeon</option> "
  . "<option>Boatman</option> "
  . "<option>Body Guard</option> "
  . "<option>Bone Picker</option> "
  . "<option>Bounty Hunter</option> "
  . "<option>Burgher</option> "
  . "<option>Camp Follower</option> "
  . "<option>Carcassonne Shepherd</option> "
  . "<option>Charcoal Burner</option> "
  . "<option>Coachman</option> "
  . "<option>Entertainer</option> "
  . "<option>Ferryman</option> "
  . "<option>Grave Robber</option> "
  . "<option>Herrimault</option> "
  . "<option>Hunter</option> "
  . "<option>Initiate</option> "
  . "<option>Jailer</option> "
  . "<option>Knight Errant</option> "
  . "<option>Man-at-Arms</option> "
  . "<option>Marine</option> "
  . "<option>Mediator</option> "
  . "<option>Mercenary</option> "
  . "<option>Messenger</option> "
  . "<option>Militiaman</option> "
  . "<option>Miner</option> "
  . "<option>Noble</option> "
  . "<option>Outlaw</option> "
  . "<option>Outrider</option> "
  . "<option>Peasant</option> "
  . "<option>Pit Fighter</option> "
  . "<option>Protagonist</option> "
  . "<option>Rat Catcher</option> "
  . "<option>Rogue</option> "
  . "<option>Scribe</option> "
  . "<option>Seaman</option> "
  . "<option>Servant</option> "
  . "<option>Smuggler</option> "
  . "<option>Student</option> "
  . "<option>Thief</option> "
  . "<option>Thug</option> "
  . "<option>Toll Keeper</option> "
  . "<option>Tomb Robber</option> "
  . "<option>Tradesman</option> "
  . "<option>Vagabond</option> "
  . "<option>Valet</option> "
  . "<option>Watchman</option> "
  . "<option>Woodsman</option> "
  . "<option>Zealot</option> "
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
                                                                                                   

?>
