<?php namespace Dopmn\Controller;

abstract class AbstractController
{
  protected $home = 'posts';

  protected function render($page='index')
  {
    require APP . 'src/view/'.$this->home.'/'.$page.'.php';
  }
}
