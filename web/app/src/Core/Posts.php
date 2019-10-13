<?php namespace Dopmn\Core;

use Dopmn\Model\PostsModel;
use Dopmn\Util;

class Posts
{
  use Util;

  private $object;
  private $users;

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
    return $this->posts->getAllFromMonth($mm, $yyyy);
  }

  //✓
  public function avgCharCountForMonth(string $mm, string $yyyy)
  {
    $object = $this->fromDate($mm, $yyyy);

    $sum = \array_reduce(
      $object->posts,
      function($acc, $post) {
          return $acc += $this->avgCharCount($post->message);
     }
    );

    $counter = count($object->posts);

    $result = ($sum == 0 || $counter == 0) ? 0 :
              round($sum / $counter, 0, PHP_ROUND_HALF_UP);

    $object->avg_post_length = $result;
    $object->month = self::shortMonthName($yyyy, $mm);

    return $object;
  }

  public function longestCharCountForMonth(string $mm, string $yyyy)
  {
    $object = $this->fromDate($mm, $yyyy);
    $object = (array) $object->posts;

    $max = \array_reduce($object, function($acc, $post) {
      $len = $this->avgCharCount($post->message);

      if ($len > $acc)
      { $acc = $len;
      }

      return $acc;
    }, 0);

    return (object) [
      'month'=> self::shortMonthName($yyyy, $mm),
      'year'=> $yyyy,
      'largest_post_length'=> $max
    ];
  }

  // @return  Total number of posts by week
  public function weeklyTotal(string $mm, string $yyyy)
  {
    //1. Get all posts for the month
    $object = $this->posts->getAllFromMonth($mm, $yyyy);

    //2. Place posts in their respective week
    $posts_for  = [];

    foreach ($object->posts as $post)
    {
      $week = 'week'.self::weekOfMonth($post->created_time);

      if (!array_key_exists($week, $posts_for))
      { $posts_for[$week] = 0;
      }

      $posts_for[$week] += 1;
    }

    //3. Sum all posts contained in each week
    return (object) [
      'total_posts'=> $posts_for
    ];

  }

  // ✓
  // Average number of posts per user per month
  public function avgPerUser()
  {
    $this->users = $this->posts->extractAllUsers();

    $posts_for = [];
    $user      = [];

    //1. For each user...
    foreach ($this->users as $id)
    {
      //2. Gather ALL their posts
      $user[$id] =  $this->posts->getAllFromUser($id);

      //3. Tally the number of posts by month
      $posts_ctr = 0;
      foreach ($user[$id]->posts as $post)
      {
        $mm = self::monthOf($post->created_time);
        $mo = (strlen($mm) === 1 ? "0{$mm}" : $mm);

        $posts_for["month-{$mo}"] = $posts_ctr++;
      }
      $user[$id] = $posts_for; //every month
      $posts_ctr = 0;

      //4. Get the average
      $users_ids = \array_keys($user[$id]);

      //👍
      $sum = \array_reduce(
          $users_ids,
          function($_sum, $mm) use ($user, $id) {
            return $_sum += $user[$id][$mm];
          }
      );

      $user[$id]['avg'] = self::rounded($sum/count($users_ids));
    }

    return (object) [
      'posting_frequency'=> $user
    ];
    // return $user;
  }

  private function avgCharCount($post): int
  {
    return \mb_strlen($post, 'UTF8');
  }

}
