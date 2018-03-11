
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
career = new Array(
new Array(
new Array("Apprentice Grey Seer", "Apprentice Grey Seer")
),
new Array(
new Array("Black Skaven", "Black Skaven")
),
new Array(
new Array("Random", "Random"),
new Array("Agitator", "Agitator"),
new Array("Bodyguard", "Bodyguard"),
new Array("Burgher", "Burgher"),
new Array("Coachman", "Coachman"),
new Array("Entertainer", "Entertainer"),
new Array("Hunter", "Hunter"),
new Array("Jailer", "Jailer"),
new Array("Marine", "Marine"),
new Array("Mercenary", "Mercenary"),
new Array("Militiaman", "Militiaman"),
new Array("Miner", "Miner"),
new Array("Noble", "Noble"),
new Array("Outlaw", "Outlaw"),
new Array("Pit Fighter", "Pit Fighter"),
new Array("Protagonist", "Protagonist"),
new Array("Rat Catcher", "Rat Catcher"),
new Array("Runebearer", "Runebearer"),
new Array("Scribe", "Scribe"),
new Array("Seaman", "Seaman"),
new Array("Servant", "Servant"),
new Array("Smuggler", "Smuggler"),
new Array("Soldier", "Soldier"),
new Array("Student", "Student"),
new Array("Thief", "Thief"),
new Array("Toll Keeper", "Toll Keeper"),
new Array("Tomb Robber", "Tomb Robber"),
new Array("Tradesman", "Tradesman"),
new Array("Watchman", "Watchman")
)
);
function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem) {
var i, j;
var prompt;
// empty existing items
for (i = selectCtrl.options.length; i >= 0; i--) {
selectCtrl.options[i] = null; 
}
prompt = (itemArray != null) ? goodPrompt : badPrompt;
if (prompt == null) {
j = 0;
}
else {
selectCtrl.options[0] = new Option(prompt);
j = 1;
}
if (itemArray != null) {
// add new items
for (i = 0; i < itemArray.length; i++) {
selectCtrl.options[j] = new Option(itemArray[i][0]);
if (itemArray[i][1] != null) {
selectCtrl.options[j].value = itemArray[i][1]; 
}
j++;
}
// select first item (prompt) for sub list
selectCtrl.options[0].selected = true;
   }
}
//  End -->
</script>

