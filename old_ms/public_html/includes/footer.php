&copy; 
				<?php 				 
// display the starting year
$startYear = 1998;
// calculate the current year
$thisYear = date('Y');
if ($startYear == $thisYear) {
// if both are the same, just show the current year
echo $startYear;
}
else {
//if they're different, show both
echo "$startYear-$thisYear";
}
?>
				Magical Strings<br />
PO Box 1240 Olalla, WA 98359 (253) 857-3716