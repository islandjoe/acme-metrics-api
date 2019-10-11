<?php namespace Dopmn\Controller;

use Dopmn\Core\Post;
use Dopmn\Model\PostModel;

class PostsController extends AbstractController
{
  protected $home = 'posts';
  protected $posts;

  public function index()
  {
    $this->render();
  }

  //:posts/page/:num
  public function page(int $num)
  {
    $this->posts = (new PostModel())->getPage($num);
    $this->render('page');
  }

  //:posts/user/:id
  public function user(string $id)
  {
    $this->posts = (new PostModel())->getAllFromUser($id);
    $this->render('user');
  }

}
