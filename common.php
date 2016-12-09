<?php
function wherecolor($fdate, $fstr)
{
       if ( $fdate == null )
           $fcolor = "'grey'";
       else
           $fcolor = "''";

      switch ( substr($fstr, 0, 4) )
      {
         case "Home":
	    $fcolor = "'green'";
            break;
         case "Taco":
	    $fcolor = "'blue'";
            break;
         case "Hoot":
	    $fcolor = "'orange'";
            break;
         case "Summ":
	    $fcolor = "'tan'";
            break;
         case "Tilt":
	    $fcolor = "'red'";
            break;
         case "Mell":
	    $fcolor = "'purple'";
            break;
         case "xxxx":
	    $fcolor = "'yellow'";
            break;
         case "XXXX":
	    $fcolor = "'brown'";
            break;
         case "XXXX":
	    $fcolor = "'red'";
            break;
         default:
            $fcolor = "''";
            break;
      }

   return $fcolor;
}

function grouprows( $char, $last )
{
   // Print headers/Groups for each letter as it shows up with # for everything before 'A'
   // begin with $last=' ';  Call this before every list entry for a row.
   if ( $last == ' ' || $last == '#' )
   {
      if ( $char >= 'A' && $char <='Z' )
      {
         $last = $char;
         echo "<li class='group' id='{$last}'>{$last}</li>";
      }
      else
      {
         if ( $last == ' ' )
            echo "<li class='group' id='#'>#</li>";
         $last = '#';
      }
   }
   else
   {
   if ( $char >$last )
      {
         while ( $char >$last )
            $last++;
         echo "<li class='group' id='{$last}'>{$last}</li>";
      }
   }
   return $last;
}

function icons( $fstr )
{
   $fgraf = " ";
   if (stripos( $fstr, ":") <> FALSE)
      $temp = substr($fstr, 0, stripos( $fstr, ":"));
   else
      $temp = $fstr;

   // Appearance
   if ( substr(stristr($temp, "dark"), 0, 4) <> null )
	;
   if ( substr(stristr($temp, "light"), 0, 5) <> null )
	;
   if ( substr(stristr($temp, "amber"), 0, 5) <> null )
	;
   if ( substr(stristr($temp, "red"), 0, 3) <> null )
	;
   // Mouthfeel
   if ( substr(stristr($temp, "stout"), 0, 5) <> null )
	;
   if ( substr(stristr($temp, "wheat"), 0, 5) <> null )
	;
   if ( substr(stristr($temp, "ale"), 0, 3) <> null )
	;

   if ( substr(stristr($temp, "high"), 0, 4) <> null )
	$fgraf = $fgraf . "<img title='High Gravity >6%' src='images/tulip.gif'>";

   if ( substr(stristr($temp, "bottle"), 0, 6) <> null )
	$fgraf = $fgraf . "<img title='in a Bottle' src='images/bottle.png'>";
   if ( substr(stristr($temp, "draft"), 0, 5) <> null )
	$fgraf = $fgraf . "<img title='On Draught' src='images/draught.gif'>";
   if ( substr(stristr($temp, "draught"), 0, 7) <> null )
	$fgraf = $fgraf . "<img title='On Draught' src='images/draught.gif'>";
   if ( substr(stristr($temp, "cask"), 0, 4) <> null )
	$fgraf = $fgraf . "<img title='Cask/Firkin' src='images/cask.png'>";
   if ( substr(stristr($temp, "can"), 0, 3) <> null )
	$fgraf = $fgraf . "<img title='Can' src='images/can.png'>";
   // Hoppyness
   if ( substr(stristr($temp, "hop"), 0, 3) <> null )
	$fgraf = $fgraf . "<img title='Hoppy' src='images/hop.png'>";
   if ( substr(stristr($temp, "hop+"), 0, 4) <> null )
	$fgraf = $fgraf . "<img title='Hoppy+' src='images/hop.png'>";
   if ( substr(stristr($temp, "hop++"), 0, 5) <> null )
	$fgraf = $fgraf . "<img title='Hoppy++' src='images/hop.png'>";

   if ( $fgraf == " " )
        $fgraf = $fgraf . "<img title='No Container' src='images/what.png'>";

   return $fgraf;
}
?>