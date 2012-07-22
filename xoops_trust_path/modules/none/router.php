<?php

class None_Router
{
    public function init($opt)
    {
        $this->mytrustdirname = $opt['mytrustdirname'];
        $this->mydirname = $opt['mydirname'];
        $this->mydirpath = $opt['mydirpath'];
    }

    // for backword compatibility...
    public function doAction()
    {
        require_once XOOPS_TRUST_PATH . '/modules/' . $opt['mytrustdirname'] . '/action.php';
        $actionName = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : 'index';
        $actionName = preg_replace('/[\W]/', '', $actionName);
        $action = new None_Action($this->mydirname);

        if (is_null($action) || !method_exists($action, $actionName)) {
            exit('Invalid request.');
        }
        $action->$actionName();
    }

    public function execute()
    {
        $controllerName = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
        $controllerName = preg_replace('/[\W]/', '', $controllerName);
        $viewName = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 'index';
        $viewName = preg_replace('/[\W]/', '', $viewName);

        if (empty($controllerName)) {
            $controllerClassName = 'AppController';
        } else {
            $controllerClassName = ucfirst(strtolower($this->mydirname)) . ucfirst(strtolower($controllerName)) . 'Controller';
        }
        $controllerFilename = XOOPS_TRUST_PATH . "/modules/{$this->mytrustdirname}/class/{$controllerClassName}.class.php";

        if (file_exists($controllerFilename)) {
            require_once $controllerFilename;
        } else {
            exit('Invalid request.');
        }

        $controller = new $controllerClassName($this->mydirname, $controllerName);
        if (is_null($viewName) || !method_exists($controller, $viewName)) {
            exit('Invalid request.');
        }
        $controller->prepare($viewName);
        $controller->$viewName();
        $controller->postView();
    }

}
