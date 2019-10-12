<?php namespace Dopmn\Controller;

use Dopmn\Core\Posts;

class PostsController extends AbstractController
{
  protected $home = 'posts';
  protected $posts;
  protected $avg_char_count_month;
  protected $max_char_count_month;
  protected $posts_by_week;

  public function index()
  {
    $this->render();
  }

  //:posts/page/:num
  public function page(int $num)
  {
    $this->posts = (new Posts())->fromPage($num);
    $this->render('page');
  }

  //:posts/user/:id
  public function user(string $id)
  {
    $this->posts = (new Posts())->fromUser($id);
    $this->render('user');
  }


  //:posts/month/:mm
  //  Where `:mm` = '01'..'12'
  public function month(string $mm, string $yyyy)
  {
    $this->posts = (new Posts())->fromDate($mm, $yyyy);
    $this->render('month');
  }

  // @return Average character count of a post on a given month
  //:posts/avg/:mm/:yyyy
  public function avg(string $mm, string $yyyy)
  {
    $this->avg_char_count_month = (new Posts())->avgCharCountForMonth($mm, $yyyy);
    $this->render('avg');
  }

  //:posts/maximum/:mm/:yyyy
  public function maximum(string $mm, string $yyyy)
  {
    $this->max_char_count_month = (new Posts())->longestCharCountForMonth($mm, $yyyy);
    $this->render('maximum');
  }

  //:posts/weekly/:mm/:yyyy
  public function weekly(string $mm, string $yyyy)
  {
    $this->posts_by_week = (new Posts())->weeklyTotal($mm, $yyyy);
    $this->render('weekly');
  }
}
