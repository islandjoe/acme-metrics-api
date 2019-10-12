<?php namespace Dopmn\Core;

use Dopmn\Model\PostsModel;
use Carbon\Carbon;

class Posts
{
  private $posts;
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

  //Returns 0
  public function avgCharCountForMonth(string $mm, string $yyyy)
  {
    $posts = $this->fromDate($mm, $yyyy);
    $sum = 0;
    $counter = 0;

    foreach ($posts as $post) {
      $sum += $this->avgCharCount($post->message);
      $counter++;
    }

    return ($sum == 0 || $counter == 0) ? 0 : round($sum / $counter, 0, PHP_ROUND_HALF_UP);
  }


  public function longestCharCountForMonth(string $mm, string $yyyy)
  {
    $posts = $this->fromDate($mm, $yyyy);

    $max = \array_reduce($posts, function($acc, $post) {
      $len = $this->avgCharCount($post->message);
      if ($len > $acc) $acc = $len;
      return $acc;
    }, 0);

    return $max;
  }

  // @return  Total number of posts by week
  public function weeklyTotal(string $mm, string $yyyy): array
  {
    //1. Get all posts for the month
    $posts = $this->posts->getAllFromMonth($mm, $yyyy);

    //2. Assign posts to their respective week
    $posts_for = [];

    $ctr1 = 0;
    $ctr2 = 0;
    $ctr3 = 0;
    $ctr4 = 0;
    $ctr5 = 0;

    foreach ($posts as $id=> $post)
    {
      $week = Carbon::parse($post->created_time)->weekOfMonth;
      if ($week == 1) $posts_for['week1'] = $ctr1++;
      if ($week == 2) $posts_for['week2'] = $ctr2++;
      if ($week == 3) $posts_for['week3'] = $ctr3++;
      if ($week == 4) $posts_for['week4'] = $ctr4++;
      if ($week == 5) $posts_for['week5'] = $ctr5++;
    }

    //3. Sum all posts contained in each week
    return $posts_for;
  }

  // Average number of posts per user per month
  public function avgPerUser()
  {
    $this->users = $this->posts->extractAllUsers();
    $posts_for = [];
    $user;

    //1. For each user...
    foreach ($this->users as $id)
    {
      //2. Gather ALL their posts
      $user[$id] =  $this->posts->getAllFromUser($id);

      //3. Tally the number of posts by month
      $posts_ctr = 0;
      foreach ($user[$id] as $post)
      {
        $month_of = function() use ($post) {
          return 'month-'.Carbon::parse($post->created_time)->month;
        };

        $posts_for[$month_of()] = $posts_ctr++;
      }
      $user[$id] = $posts_for; //every month
      $posts_ctr = 0;

      //4. Get the average
      $sum = 0;
      $count = 0;
      foreach (\array_keys($user[$id]) as $month)
      {
        $sum += $user[$id][$month];
        $count++;
      }
      $user[$id]['avg'] = $sum / $count;

      $sum = 0;
      $count = 0;
    }

    return $user;
  }

  private function avgCharCount($post): int
  {
    return \mb_strlen($post, 'UTF8');
  }

}
