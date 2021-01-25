<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Psr\Http\Message\ResponseInterface as Response;


//GLOBAL FUNCTIONS


if (!function_exists('dd'))
{
    /**
     * die and var_dump 
     *
     * @return void
     */
    function dd()
    {
        array_map(function ($content) {
            echo "<pre>";
            var_dump($content);
            echo "</pre>";
            echo "<hr>";
        }, func_get_args());

        die;
    }
}

if(!function_exists('base_path')) {

    function base_path(string $path = '') {
        return dirname(__DIR__,2) . DIRECTORY_SEPARATOR . $path;
    }
}

if(!function_exists('view_path')) {

    function view_path(string $path = '') {
        return base_path('views') . DIRECTORY_SEPARATOR . $path;
    }
}

if(!function_exists('db_config')) {
    function db_config(string $key) {

        $dbConfig = require base_path('settings') . "/db_settings.php";
            if(array_key_exists($key,$dbConfig)){
                return $dbConfig[$key];
            }
            $value = array_key_exists("default",$dbConfig) ? $dbConfig["connections"][$dbConfig["default"]][$key] : null;
            return $value;
    }
}

if(!function_exists('make_email')) {
    function make_email(string $filename,array $data = []) {
        extract($data);
        ob_start();
        include (view_path('emails') . DIRECTORY_SEPARATOR . $filename . '.php');
        return $content = ob_get_clean();
        //return $content;
    }
}

if(!function_exists('view')) {
    /**
     * view renderer
     *
     * @param Response $response
     * @param string $view 
     * @param array|null $vars
     * @return Response
     */
    function view(Response $response, string $view,?array $vars = []):Response {
        
        //load twig filesystem
        $dir = view_path();
        $loader = new Filesystemloader($dir);
        $twig = new Environment($loader,[
            'cache' => base_path('cache')
        ]);

        $view = str_replace('.', DIRECTORY_SEPARATOR,$view) . '.html.twig';
        $file = $dir . DIRECTORY_SEPARATOR . $view;

        if(file_exists($file)) {
            $response->getBody()->write($twig->render($view,$vars));
            return $response;
        } else {
            throw new \Exception('VIEW_RENDERER_Exception: cannot find ' . $view);
        }
    }
}