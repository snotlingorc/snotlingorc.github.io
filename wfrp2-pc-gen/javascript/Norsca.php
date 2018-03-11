
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
career = new Array(
new Array(
new Array("Random", "Random"),
new Array("Berserker", "Berserker"),
new Array("Bodyguard", "Bodyguard"),
new Array("Bondsman", "Bondsman"),
new Array("Burgher", "Burgher"),
new Array("Entertainer", "Entertainer"),
new Array("Fisherman", "Fisherman"),
new Array("Hunter", "Hunter"),
new Array("Mercenary", "Mercenary"),
new Array("Outlaw", "Outlaw"),
new Array("Peasant", "Peasant"),
new Array("Pit Fighter", "Pit Fighter"),
new Array("Reaver", "Reaver"),
new Array("Seaman", "Seaman"),
new Array("Seer", "Seer"),
new Array("Servant", "Servant"),
new Array("Skald", "Skald"),
new Array("Tradesman", "Tradesman"),
new Array("Whaler", "Whaler"),
new Array("Woodsman", "Woodsman")
),
new Array(
new Array("Random", "Random"),
new Array("Berserker", "Berserker"),
new Array("Bodyguard", "Bodyguard"),
new Array("Bondsman", "Bondsman"),
new Array("Burgher", "Burgher"),
new Array("Entertainer", "Entertainer"),
new Array("Hunter", "Hunter"),
new Array("Mercenary", "Mercenary"),
new Array("Militiaman", "Militiaman"),
new Array("Miner", "Miner"),
new Array("Outlaw", "Outlaw"),
new Array("Pit Fighter", "Pit Fighter"),
new Array("Reaver", "Reaver"),
new Array("Seaman", "Seaman"),
new Array("Servant", "Servant"),
new Array("Shieldbreaker", "Shieldbreaker"),
new Array("Skald", "Skald"),
new Array("Soldier", "Soldier"),
new Array("Tradesman", "Tradesman"),
new Array("Troll Slayer", "Troll Slayer")
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

