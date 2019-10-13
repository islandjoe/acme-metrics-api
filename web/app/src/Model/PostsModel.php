<?php namespace Dopmn\Model;

use Exception;
use Dopmn\Core\DataFetcher;
use Dopmn\Util;

use Carbon\Carbon;

class PostsModel
{
  use Iterator;
  use Util;

  private $posts = [];
  private $store;

  public function __construct()
  { // Fetch ALL posts
    $this->store = DataFetcher::getInstance()->getStore();
  }

  public function getAllFromPage(int $num): object
  {
    if ($num > 0 && $num < 11)
    { return $this->store[$num - 1]->data;
    }

    return (object)[
      'page'=> $num, 'posts'=> []
    ];
  }

  // Fetch ALL the posts of this user
  public function getAllFromUser(string $id)
  {
    foreach ($this->iterate($this->store) as $data)
    {
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

  // Fetch ALL posts from all users on month `mm`
  public function getAllFromMonth(string $mm, string $yyyy): object
  {
    foreach ($this->iterate($this->store) as $data)
    {
      foreach ($data as $posts)
      {
        if (\substr($posts->created_time, 0, 7) === "{$yyyy}-{$mm}")
        { $this->posts[] = $posts;
        }
      }
    }

    return (object) [
      'month'=> self::shortMonthName($yyyy, $mm),
      'year' => $yyyy,
      'posts'=> $this->posts
    ];
  }

  // Fetch all user ids: ['user_id', ...]
  public function extractAllUsers()
  {
    foreach ($this->iterate($this->store) as $data)
    {
      $users = array_column((array) $data, 'from_id');
    }
    return array_unique($users);
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