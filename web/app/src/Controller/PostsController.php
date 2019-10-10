<?php namespace Dopmn\Controller;

use Dopmn\Core\Post;
use Dopmn\Model\PostModel;

class PostsController extends AbstractController
{
  protected $home = 'posts';
  protected $posts;

  /**
   *  http://localhost/
   */
  public function index()
  {
    $this->render();
  }

  public function page(int $num)
  {
    $this->posts = (new PostModel())->getPage($num);
    $this->render('page');
  }



}
