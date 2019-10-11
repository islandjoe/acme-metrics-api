<?php namespace Dopmn\Core;

class DataFetcher
{
  private static $instance;
  private $store;

  private function __construct()
  {
    $this->store = self::fetch();
  }

  public function getStore()
  {
    return $this->store;
  }

  private static function fetch()
  {
    foreach (range(1, 10) as $num)
    {
      $_data[] = json_decode(
        \file_get_contents( APP.'src/View/posts/p'.$num.'.json')
      );
    }
    return $_data;
  }

  public static function getInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new DataFetcher();
    }
    return self::$instance;
  }

}
