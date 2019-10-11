<?php namespace Dopmn\Model;

use Exception;
use Dopmn\Core\Post;
use Dopmn\Core\DataFetcher;

class PostModel
{
  private $posts = [];

  public function getAllFromPage(int $num)
  {
    if ($num > 0 || $num < 11)
    {
      $store = DataFetcher::getInstance();
      $page  = $store->getStore();

      return $page[$num - 1];;
    }

    // TODO: Flash the message: 'Only between 1 and 10'
  }

  public function getAllFromUser(string $id)
  {

    $store = DataFetcher::getInstance()->getStore();

    foreach ($this->iterate($store) as $data)
    {
      foreach ($data as $posts)
      {
        if ($posts->from_id === $id) { $this->posts[] = $posts; }
      }
    }

    return $this->posts;
  }


  public function getAllFromMonth(string $mm)
  {
    $data = DataFetcher::getInstance()->getStore();
  }

  private function iterate(array $data)
  {
    foreach ($data as $obj)
    {
      yield $obj->data->posts;
    }
  }

}

trait Iterator
{
  public function iterate()
  {

  }
}