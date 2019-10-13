<?php namespace Dopmn;

use Carbon\Carbon;

trait Util
{
  public static function shortMonthName($yyyy, $mm)
  {
    return Carbon::create($yyyy, $mm)->shortMonthName;
  }

  public static function weekOfMonth($created_time)
  {
    return Carbon::parse($created_time)->weekOfMonth;
  }

  public static function monthOf($created_time)
  {
    return Carbon::parse($created_time)->month;
  }
}