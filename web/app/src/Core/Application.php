<?php namespace Dopmn\Core;

use Dopmn\Controller\HomeController;
use Dopmn\Controller\ErrorController;

class Application
{
    private $url_controller = null;
    private $url_action     = null;
    private $url_params     = [];

    public function __construct()
    {
        try
        {
            $this->deconstructURL();

            if ($this->isMainIndex())
            {
                (new HomeController())->index();
            }
            elseif ($this->isSubIndex())
            {
                $this->url_controller = $this->controller();

                if ($this->controllerHasAction())
                {   // Call the action method
                    $this->url_controller->{$this->url_action}(...$this->url_params);
                }
                else
                {   // Go to Sub index page instead
                    $this->url_controller->index();
                }
            }
        }
        catch (Exception $e)
        {
            (new ErrorController())->index();
        }
    }

    private function deconstructURL() //into component parts
    {
        if (isset($_GET['url']))
        {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = $url[0] ?? null;
            $this->url_action     = $url[1] ?? null;

            // Discard controller and action...
            unset($url[0], $url[1]);

            // but keep the args, if any
            $this->url_params = array_values($url);

            // for debugging. uncomment this if you have problems with the URL
            // echo 'Controller: ' . $this->url_controller . '<br>';
            // echo 'Action: ' . $this->url_action . '<br>';
            // echo 'Parameters: ' . print_r($this->url_params, true) . '<br>';
        }
    }

    private function isSubIndex(): bool
    {
        $controller = APP.'src/Controller/'.ucfirst($this->url_controller).'Controller.php';

        return file_exists($controller);
    }

    private function isMainIndex(): bool
    {
        return !$this->url_controller;
    }

    private function controller()
    {
        $controller = "Dopmn\\Controller\\".ucfirst($this->url_controller).'Controller';

        return new $controller();
    }

    private function controllerHasAction(): bool
    {
        return method_exists($this->url_controller, $this->url_action)
               &&
               is_callable(array($this->url_controller, $this->url_action));
    }

    private function hasArguments(): bool
    {
        return !empty($this->url_params);
    }
}
