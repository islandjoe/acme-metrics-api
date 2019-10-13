<?php namespace Dopmn;

use Carbon\Carbon;

trait Util
{
  public static function shortMonthName($yyyy, $mm)
  {
    return Carbon::create($yyyy, $mm)->shortMonthName;
  }
}