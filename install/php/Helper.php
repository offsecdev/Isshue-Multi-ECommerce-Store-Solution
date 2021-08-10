<?php
    
    define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
    
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;

        case 'testing':
        case 'production':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>='))
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
            }
            else
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
            }
        break;

        default:
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo 'The application environment is not set correctly.';
            exit(1); // EXIT_ERROR
    }


    function d($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }
    // Filter input data
     function filterInput($data = null)
    { 
        //if not empty posted data
        if (!empty($data)) { 
            $data = trim($data);
            $data = filter_var($data, FILTER_SANITIZE_STRING);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        return false;
    }

    // Check Project https
    if ( ! function_exists('is_https'))
    {
        function is_https()
        {
            if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
            {
                return TRUE;
            }
            elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
            {
                return TRUE;
            }
            elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
            {
                return TRUE;
            }

            return FALSE;
        }
    }

    // Get Project base_url
    if ( ! function_exists('base_url'))
    {
        function base_url(){

            $base_url = (is_https() ? "https://" : "http://").$_SERVER["HTTP_HOST"];
            $base_url.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
            return $base_url;

        }
    }


    // Redirect page
    if ( ! function_exists('redirect'))
    {
        function redirect($url)
        {
            header('location:'.base_url().$url);
        }
    }

    // CSRF Token Generate
    if ( ! function_exists('gen_csrf_token'))
    {
        function gen_csrf_token()
        {
            if (function_exists('random_bytes')) {
                $token= bin2hex(random_bytes(32));
            } else {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
            }
            return $token;
        }
    }

    

?>