<?php


class Router
{
    /**
     * Binds routes to actions
     */
    private $routes = [
        'product/([0-9]+)' => 'product/view/$1',
        'product/add' => 'product/add',
        'product/delete/([0-9]+)' => 'product/delete/$1',
        'product/features/([0-9]+)' => 'product/addFeatures/$1',
        'product/edit/([0-9]+)' => 'product/edit/$1',
//        'cart/add/([0-9]+)' => 'cart/add/$1',
//        'cart/clear' => 'cart/clear',
//        'cart/delete/([0-9]+)' => 'cart/delete/$1',
//        'cart' => 'cart/index',
        'user/register' => 'user/register',
        'user/login' => 'user/login',
        'user/logout' => 'user/logout',
//        'cabinet/add' => 'cabinet/add',
//        'cabinet/update/([0-9]+)' => 'cabinet/update/$1',
//        'cabinet/delete/([0-9]+)' => 'cabinet/delete/$1',
        'cabinet' => 'cabinet/index',
        '' => 'site/index/$1',
    ];

    /**
     * Returns request string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        return false;
    }

    public function run()
    {
        // Get query string
        $uri = $this->getURI();

        // Check such request in routes
        foreach ($this->routes as $uriPattern => $path) {

            // Compare $uriPattern and $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Get the internal path from uri
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Split into controller, action, and additional params
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // Include a controller class
                $controllerFile = ROOT . '/controllers/' .
                    $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Make instance of controller class
                $controllerObject = new $controllerName;

                // Call action $actionName of controller $controllerObject with params $parameters
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                } else {
                    call_user_func_array(array(new SiteController, 'actionIndex'), []);
                }
            }
        }
    }

}
