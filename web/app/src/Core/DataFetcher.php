<?php namespace Dopmn\Core;

class DataFetcher
{
  private static $instance;
  private $data;

  private function __construct()
  {
    $this->data = self::fetch();
  }

  public function getData()
  {
    return $this->data;
  }

  private static function fetch()
  {
    foreach (range(1, 3) as $num)
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
