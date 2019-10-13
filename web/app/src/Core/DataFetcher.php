<?php namespace Dopmn\Core;

class DataFetcher
{
  private static $instance;
  private static $range;
  private $store;

  private function __construct()
  {
    self::$range = range(1, 10);

    $this->store = self::fetchAll();
  }

  public function getStore()
  {
    return $this->store;
  }

  // Fetches ALL the posts in the store
  private static function fetchAll()
  {
    foreach (self::$range as $num)
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
