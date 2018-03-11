<?php

echo ""
. "<p><img src=images/wfrplogo.gif><br>"
. "<p>Warhammer V2 Character Generator.
	This program follows the rules in the Warhammer Fantasy Role Play 
	Rule Book Version 2. <p>"
. "<table border=0><tr>"
. "<th valign=top align=right>Must Select:</th>"
. "<td valign=top>" ;


echo "<IMG style=\"border-color:#000000\" border=1 SRC=\"images/owmap.jpg\"
	USEMAP=\"#owmap\" HEIGHT=304 WIDTH=400>";
echo "<MAP NAME=\"owmap\">";
# echo "<AREA SHAPE=RECT COORDS=\"60,0 130,30\" HREF=\"index-albion.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"250,261 232,225 251,195 327,173 400,159 400,211 347,211 279,226 250,261\" HREF=\"index-border.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"138,170 77,133 39,214 136,261 164,215 211,188 138,170\" HREF=\"index-estalia.php\">";
echo "<AREA SHAPE=POLY COORDS=\"143,166 240,193 258,142 208,96 166,87 168,32 106,61 143,166\" HREF=\"index-bretonnia.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"172,31 170,85 211,93 255,76 237,23 172,31\" HREF=\"index-waste.php\">";
echo "<AREA SHAPE=POLY COORDS=\"151,32 275,14 275,0 151,0 151,32\" HREF=\"index-norsca.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"227,303 279,230 347,215 400,214 400,304 228,304 227,303\" HREF=\"index-badlands.php\">";
echo "<AREA SHAPE=POLY COORDS=\"299,0 400,0 400,95 330,68 299,0\" HREF=\"index-kislev.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"321,171 289,124 349,123 400,156 321,171\" HREF=\"index-moot.php\">
echo "<AREA SHAPE=POLY COORDS=\"214,97 260,78 241,22 301,13 328,71 400,100 400,151 350,119 284,122 317,173 245,193 263,142 214,97\" HREF=\"index-empire.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"167,218 145,262 153,295 202,299 245,258 227,225 244,198 216,190 167,218\" HREF=\"index-tilea.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"0,126 0,213 33,213 73,126 0,126\" HREF=\"index-newworld.php\">";
# echo "<AREA SHAPE=POLY COORDS=\"81,251 81,304 0,304 0,251 81,251\" HREF=\"index-araby.php\">";

echo "</MAP> ";
echo "<br>";
echo "<a href=index-empire.php>Empire</a> | ";
echo "<a href=index-bretonnia.php>Bretonnia</a> | ";
echo "<a href=index-norsca.php>Norsca</a> | ";
echo "<a href=index-kislev.php>Kislev</a> | ";
#echo "<a href=index-princes.php>"._BPRINCES_."</a> | ";
#echo "<a href=index-vampire.php>"._VAMPIRE_."</a> | ";
echo "<a href=index-skaven.php>Skaven</a>";

echo ""
. "</td></tr>"
. "</table>"
. "<p>"
. "Any Comments/Questions can be mail to the author : <img align=center src =images/email.gif>"  . "<p>"
. "<p>"
. "<center><font size=2>Created by wfrp2-pc-gen v1.0</font><br>"
. "<font size=2><a href=todo.php>Changelog/Todo List</a></font>"
. "<br>"
. "<font size=-2>Warhammer and other Warhammer Fantasy Rople Play (and the Logo's) are (probably registered) trademarks of Games Workshop and/or Green Ronin and/or Black Industries.  The use of trademarks and materials are not meant as a challange to their rights and is not intended to make or lose any money for anyone. "
. "</font></center>"
//  . "To see what is new in the next version, select this <a href=nextversion.html>link</a>."
."";


?>
