<?php namespace Dopmn\Core;

use Dopmn\Model\PostsModel;

class Posts
{
  private $posts;

  public function __construct()
  {
    $this->posts = new PostsModel();
  }

  public function fromUser(string $userid)
  {
    return $this->posts->getAllFromUser($userid);
  }

  public function fromPage(int $num)
  {
    return $this->posts->getAllFromPage($num);
  }

  public function fromDate(string $mm, string $yyyy)
  {
    return $this->posts->getAllFromMonth($yyyy.'-'.$mm);
  }

  public function avgCharCountForMonth(string $mm, string $yyyy)
  {
    $posts = $this->fromDate($mm, $yyyy);
    $sum = 0;
    $counter = 0;

    foreach ($posts as $post) {
      $sum += mb_strlen($post->message, 'UTF8');
      $counter++;
    }

    return round($sum / $counter, 0, PHP_ROUND_HALF_UP);
  }

}