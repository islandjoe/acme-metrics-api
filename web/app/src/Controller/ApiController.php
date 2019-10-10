<?php namespace Dopmn\Controller;

use Dopmn\Core\Post;
use Dopmn\Model\PostModel;

class ApiController extends AbstractController
{
  protected $home = 'api';
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
