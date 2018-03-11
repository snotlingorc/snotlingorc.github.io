
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
career = new Array(
new Array(
new Array("Random", "Random"),
new Array("Agitator", "Agitator"),
new Array("Apprentice Witch", "Apprentice Witch"),
new Array("Bailiff", "Bailiff"),
new Array("Barber-Surgeon", "Barber-Surgeon"),
new Array("Bear Tamer", "Bear Tamer"),
new Array("Boatman", "Boatman"),
new Array("Bodyguard", "Bodyguard"),
new Array("Bone Picker", "Bone Picker"),
new Array("Bounty Hunter", "Bounty Hunter"),
new Array("Burgher", "Burgher"),
new Array("Camp Follower", "Camp Follower"),
new Array("Charcoal-Burner", "Charcoal-Burner"),
new Array("Chekist", "Chekis")
new Array("Coachman", "Coachman"),
new Array("Drover", "Drover"),
new Array("Entertainer", "Entertainer"),
new Array("Ferryman", "Ferryman"),
new Array("Fisherman", "Fisherman"),
new Array("Grave Robber", "Grave Robber"),
new Array("Hedge Wizard", "Hedge Wizard"),
new Array("Hunter", "Hunter"),
new Array("Initiate", "Initiate"),
new Array("Jailer", "Jailer"),
new Array("Kossar", "Kossar"),
new Array("Marine", "Marine"),
new Array("Mercenary", "Mercenary"),
new Array("Militiaman", "Militiaman"),
new Array("Miner", "Miner"),
new Array("Noble", "Noble"),
new Array("Outlaw", "Outlaw"),
new Array("Outrider", "Outrider"),
new Array("Peasant", "Peasant"),
new Array("Pit Fighter", "Pit Fighter"),
new Array("Protagonist", "Protagonist"),
new Array("Rat Catcher", "Rat Catcher"),
new Array("Rogue", "Rogue"),
new Array("Scribe", "Scribe"),
new Array("Seaman", "Seaman"),
new Array("Servant", "Servant"),
new Array("Smuggler", "Smuggler"),
new Array("Streltsi", "Streltsi"),
new Array("Student", "Student"),
new Array("Thief", "Thief"),
new Array("Thug", "Thug"),
new Array("Toll Keeper", "Toll Keeper"),
new Array("Tomb Robber", "Tomb Robber"),
new Array("Tradesman", "Tradesman"),
new Array("Vagabond", "Vagabond"),
new Array("Valet", "Valet"),
new Array("Watchman", "Watchman"),
new Array("Woodsman", "Woodsman"),
new Array("Zealot", "Zealot")
),
new Array(
new Array("Random", "Random"),
new Array("Agitator", "Agitator"),
new Array("Bailiff", "Bailiff"),
new Array("Barber-Surgeon", "Barber-Surgeon"),
new Array("Bear Tamer", "Bear Tamer"),
new Array("Boatman", "Boatman"),
new Array("Bodyguard", "Bodyguard"),
new Array("Bone Picker", "Bone Picker"),
new Array("Bounty Hunter", "Bounty Hunter"),
new Array("Burgher", "Burgher"),
new Array("Camp Follower", "Camp Follower"),
new Array("Charcoal-Burner", "Charcoal-Burner"),
new Array("Chekist", "Chekis")
new Array("Coachman", "Coachman"),
new Array("Drover", "Drover"),
new Array("Entertainer", "Entertainer"),
new Array("Ferryman", "Ferryman"),
new Array("Fisherman", "Fisherman"),
new Array("Grave Robber", "Grave Robber"),
new Array("Hedge Wizard", "Hedge Wizard"),
new Array("Hunter", "Hunter"),
new Array("Initiate", "Initiate"),
new Array("Jailer", "Jailer"),
new Array("Kossar", "Kossar"),
new Array("Marine", "Marine"),
new Array("Mercenary", "Mercenary"),
new Array("Militiaman", "Militiaman"),
new Array("Miner", "Miner"),
new Array("Noble", "Noble"),
new Array("Outlaw", "Outlaw"),
new Array("Outrider", "Outrider"),
new Array("Peasant", "Peasant"),
new Array("Pit Fighter", "Pit Fighter"),
new Array("Protagonist", "Protagonist"),
new Array("Rat Catcher", "Rat Catcher"),
new Array("Rogue", "Rogue"),
new Array("Scribe", "Scribe"),
new Array("Seaman", "Seaman"),
new Array("Servant", "Servant"),
new Array("Smuggler", "Smuggler"),
new Array("Steepes Nomad", "Steepes Nomad"),
new Array("Streltsi", "Streltsi"),
new Array("Student", "Student"),
new Array("Thief", "Thief"),
new Array("Thug", "Thug"),
new Array("Toll Keeper", "Toll Keeper"),
new Array("Tomb Robber", "Tomb Robber"),
new Array("Tradesman", "Tradesman"),
new Array("Vagabond", "Vagabond"),
new Array("Valet", "Valet"),
new Array("Watchman", "Watchman"),
new Array("Wise Woman", "Wise Woman"),
new Array("Woodsman", "Woodsman"),
new Array("Zealot", "Zealot")
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

