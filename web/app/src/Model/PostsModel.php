<?php namespace Dopmn\Model;

use Exception;
use Dopmn\Core\DataFetcher;

class PostsModel
{
  use Iterator;

  private $posts = [];
  private $store;

  public function __construct()
  { // Fetched ALL posts
    $this->store = DataFetcher::getInstance()->getStore();
  }

  public function getAllFromPage(int $num): object
  {
    if ($num > 0 && $num < 11)
    { return $this->store[$num - 1]->data;
    }

    return (object)['page'=> $num, 'posts'=> []];
  }

  // @returns ALL the posts from this user
  public function getAllFromUser(string $id)
  {
    // 👀
    foreach ($this->iterate($this->store) as $data)
    {
      // 👀
      foreach ($data as $posts)
      {
        if ($posts->from_id === $id) { $this->posts[] = $posts; }
      }
    }
    return (object) [
      'user_id'=> $id,
      'posts'=> $this->posts
    ];
  }


  public function getAllFromMonth(string $mm, string $yyyy)
  {
    // '2019-09-21T23:05:58+00:00'...
    $dx = function($date) {
      return \substr($date, 0, 7); //-> '2019-09'
    };

    foreach ($this->iterate($this->store) as $data)
    { // 👀
      foreach ($data as $posts)
      {
        if ($dx($posts->created_time) === $yyyy.'-'.$mm)
        { $this->posts[] = $posts;
        }
      }
    }
    return $this->posts;
  }

  // @returns ['user_id', ...]
  public function extractAllUsers()
  {
    $users = [];
    foreach ($this->iterate($this->store) as $data)
    {
      // 👀
      foreach ($data as $posts)
      {
        if ( !in_array($posts->from_id, $users))
        {
          $users[] = $posts->from_id;
        }
      }
    }
    return $users;
  }

}

trait Iterator
{
  public function iterate(array $data)
  {
    foreach ($data as $obj)
    { yield $obj->data->posts;
    }
  }
}