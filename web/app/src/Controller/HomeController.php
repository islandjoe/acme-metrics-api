<?php namespace Dopmn\Controller;

class HomeController extends AbstractController
{
    /**
     *  http://localhost/
     */
    public function index()
    {
        $this->render();
    }

    /**
     * http://localhost/subdir
     *
     * Notice that you can call the action in lowercase
     *  even though the method is camelcased.
     */
    public function subDir()
    {
        // http://localhost/subdir/index.php
        $this->render('subdir');
        // Make sure this exists: web/app/src/View/subdir/index.php
    }

}
