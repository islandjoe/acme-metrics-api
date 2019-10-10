<?php namespace Dopmn\Controller;

use Dopmn\Controller\AbstractController;

class ErrorController extends AbstractController
{
    protected $home = 'error';

    public function index()
    {
        $this->render();
    }
}
