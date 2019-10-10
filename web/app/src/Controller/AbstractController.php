<?php namespace Dopmn\Controller;

abstract class AbstractController
{
  protected $home = 'home';

  protected function render($page='index')
  {
    // require APP . 'src/view/header.php';
    require APP . 'src/view/'.$this->home.'/'.$page.'.php';
    // require APP . 'src/view/footer.php';
  }
}
