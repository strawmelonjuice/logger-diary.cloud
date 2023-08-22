<?php
function RandomEntryPlaceholder() {
    $EntryPlaceholder = $_SESSION['LANG'][21];
    $EntryPlaceholder = $EntryPlaceholder[array_rand($EntryPlaceholder)];
    return $EntryPlaceholder;
}
function AddPrefilledEntryOpenFormGen(string $entry, string $feel,$StreakCelebration){
    return '<form action="/add-entry.php" method="post" style="text-align: center"><input type="hidden" name="new_entry" value="' . $entry. '"><input type="hidden" name="new_entry_feel" value="' . $feel . '"><input type="hidden" name="StreakCelebration" value="' . $StreakCelebration . '">';
}
function DayStreakCelebrations($streak) {
    $StreakCelebrations = array();
    $StreakCelebrations[0] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][1],"0️⃣🗓️",1) . '<button type="submit">';
    $StreakCelebrations[1] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][2],"🗓️",1) . '<button type="submit">';
    $StreakCelebrations[7] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][3],"7️⃣🗓️",1) . '<button type="submit">';
    $StreakCelebrations[30] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][4],"🎇🗓️",1) . '<button type="submit">';
    $StreakCelebrations[100] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][5],"1️⃣0️⃣0️⃣🗓️",1) . '<button type="submit">';
    $StreakCelebrations[365] = AddPrefilledEntryOpenFormGen( $_SESSION['LANG'][54][6],"🥂🗓️",1) . '<button type="submit">';
    if (isset($StreakCelebrations[$streak])) {
        return '<p>' . $StreakCelebrations[$streak] .  $_SESSION['LANG'][53] . "</button></form></p>";
    } else {
        return NULL;
    }
}