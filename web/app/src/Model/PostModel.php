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
      $page  = $store->getData();

      return $page[$num - 1];;
    }

    // TODO: Flash the message: 'Only between 1 and 10'
  }

  public function getAllFromUser(string $id)
  {

    $store = DataFetcher::getInstance();
    $posts = $store->getData();

    foreach ($posts as $_posts)
    {
      $__posts = $_posts->data->posts;

      foreach ($__posts as $post)
      {
        if ($post->from_id === $id) { $this->posts[] = $post; }
      }
    }

    return $this->posts;
  }


  public function getAllFromMonth(int $mm)
  {
    $data = DataFetcher::getInstance();
  }

}