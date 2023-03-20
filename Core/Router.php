<?php
require_once('../App/Controllers/crypt.php');
class Router
{
    protected $routes = [];
    protected $parametres = [];

    public function add($url, $param = [])
    {
        $route = preg_replace("/~/", "~", $url);
        $route = preg_replace("/\{([a-z-]+)\}/", "(?'\\1'[a-z-]+)", $route);
        $route = preg_replace("/\{([a-z-]+):([^\}]+)\}/", "(?'\\1'\\2)", $route);

        $route = "/^" . $route . "\$/i";

        $this->routes[$route] = $param;
    }

    public function explode($url)
    {
        $crypt = new Crypt();
        if ($url !== "") {
            if (preg_match("/&/i", $url, $matches)) {
                $url = explode("&", $url);
                $url = $url[0];
                if (preg_match("/~/i", $url, $matches)) {
                    $url = explode("~", $url);
                    $url = implode("~", $url);
                    $tab_url = [];

                    $new_url = explode("~", $url);
                    foreach ($new_url as $values) {
                        $values = $crypt->datadecrypt($values);
                        array_push($tab_url, $values);
                    }
                    $url = implode("~", $tab_url);
                    return $url;
                }
            } else {
                if (preg_match("/\[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c\]/i", $url, $matches)) {
                    $url = explode("[c9fu1geqtXTszR0gTwxPrWOajaxDGZnqKYv1WuKQz979E0c]/", $url);
                    $url = $url[1];
                    return $url;
                }
                if (preg_match("/~/i", $url, $matches)) {
                    $url = explode("~", $url);
                    $url = implode("~", $url);
                    $tab_url = [];

                    $new_url = explode("~", $url);
                    foreach ($new_url as $values) {
                        $values = $crypt->datadecrypt($values);
                        array_push($tab_url, $values);
                    }
                    $url = implode("~", $tab_url);
                    return $url;
                }
            }
        } else {
            $parent = $crypt->datacrypt('home-controller');
            $child = $crypt->datacrypt('viewHome');
            $url = $parent . "~" . $child;
            if (preg_match("/~/i", $url, $matches)) {
                $url = explode("~", $url);
                $url = implode("~", $url);
                $tab_url = [];

                $new_url = explode("~", $url);
                foreach ($new_url as $values) {
                    $values = $crypt->datadecrypt($values);
                    array_push($tab_url, $values);
                }
                $url = implode("~", $tab_url);
                return $url;
            }
        }
    }

    public function match ($url)
    {
        $url = $this->explode($url);
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->parametres = $params;
                return true;
            }
        }
        return false;
    }

    public function convertToPascalCase($url)
    {
        return preg_replace("/-/", "", ucwords($url, "-"));
    }

    public function convertToCamelCase($url)
    {
        return lcfirst($this->convertToPascalCase($url));
    }

    public function autoload($classname)
    {
        return spl_autoload_register(
            function ($classname) {
                $root = "../App/Controllers";
                $file = $root . "/$classname" . ".php";
                if (is_readable($file)) {
                    require("../App/Controllers/" . $classname . ".php");
                } else {
                    echo "bad";
                    exit;
                }
            }
        );
    }


    public function dispatch($url)
    {
        if ($this->match($url)) {
            $controller = $this->parametres["controller"];
            $controller = $this->convertToPascalCase($controller);
            if ($this->autoload($controller)) {
                $controller_object = new $controller();
                $action = $this->parametres["action"];
                $action = $this->convertToCamelCase($action);
                if (method_exists($controller, $action)) {
                    $controller_object->$action();
                } else {
                    echo "La page que vous recherchez n'existe pas. Veuillez revoir le chemin que vous avez entré:";
                    exit;
                }
            } else {
                echo "null 1";
                exit;
            }
        } else {
            echo "null 2";
            exit;
        }
    }

    public function getadd()
    {
        return $this->routes;
    }

    public function getmatch()
    {
        return $this->parametres;
    }
}

?>