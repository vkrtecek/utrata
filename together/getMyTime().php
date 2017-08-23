<?php
function getMyTime()
{
  $year = date("Y");
  $month = date("m");
  $day = date("d");
  $hour = date("H");
  $minute = date("i");
  $second = date("s");
  
  return $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
}
?>