<?php
session_start();
include('../dbconn.php');
    // In case one is using PHP 5.4's built-in server
    $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

    // Include the Router class
    // @note: it's recommended to just use the composer autoloader when working with other packages too
//    require_once __DIR__ . '/../src/Bramus/Router/Router.php';
    require_once __DIR__ . '/../vendor/autoload.php';

    // Create a Router
    $router = new \Bramus\Router\Router();

    // Custom 404 Handler
    $router->set404(function () {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo '404, route not found!';
    });

    // Before Router Middleware
    $router->before('GET', '/.*', function () {
        header('X-Powered-By: bramus/router');
    });

    // Static route: / (homepage)
    $router->get('/', function () {
        echo '<h1>bramus/router</h1><p>Try these routes:<p><ul><li>/hello/<em>name</em></li><li>/blog</li><li>/blog/<em>year</em></li><li>/blog/<em>year</em>/<em>month</em></li><li>/blog/<em>year</em>/<em>month</em>/<em>day</em></li><li>/movies</li><li>/movies/<em>id</em></li></ul>';
    });

    $router->get('/my_application', function () {
        if (!isset($_SESSION['is_logged_in'])) {
            header('Location: /login'); exit;
        }

        include('inc/API_Client.php');
        $api = new API_Client();
        
        $data = $api->go('permohonan/semak/'.$_SESSION['nokp']);
        
        if (isset($data['status'])) {
            $application_status = $data['status'];
        } else {
            $application_status = 'Permohonan tidak dijumpai';
        }

        include('templates/my_application.php');
    });

    $router->get('/logout', function () {
        session_destroy();
        header('Location: /login');
    });

    $router->get('/login', function () {
        include('templates/login.php');
    });

    $router->post('/login', function () {
        global $conn;
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "select * from users where username like '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['passwd'])) {
                $_SESSION['is_logged_in'] = true;
                $_SESSION['nokp'] = $row['nokp'];
                header('Location: /my_application'); exit;
            }        
        } 

        header('Location: /login?error=1'); exit;
        
    });




    // Static route: /hello
    $router->get('/hello', function () {
        echo '<h1>bramus/router</h1><p>Visit <code>/hello/<em>name</em></code> to get your Hello World mojo on!</p>';
    });

    // Dynamic route: /hello/name
    $router->get('/hello/(\w+)', function ($name) {
        echo 'Hello ' . htmlentities($name);
    });

    // Dynamic route: /ohai/name/in/parts
    $router->get('/ohai/(.*)', function ($url) {
        echo 'Ohai ' . htmlentities($url);
    });

    // Dynamic route with (successive) optional subpatterns: /blog(/year(/month(/day(/slug))))
    $router->get('/blog(/\d{4}(/\d{2}(/\d{2}(/[a-z0-9_-]+)?)?)?)?', function ($year = null, $month = null, $day = null, $slug = null) {
        if (!$year) {
            echo 'Blog overview';

            return;
        }
        if (!$month) {
            echo 'Blog year overview (' . $year . ')';

            return;
        }
        if (!$day) {
            echo 'Blog month overview (' . $year . '-' . $month . ')';

            return;
        }
        if (!$slug) {
            echo 'Blog day overview (' . $year . '-' . $month . '-' . $day . ')';

            return;
        }
        echo 'Blogpost ' . htmlentities($slug) . ' detail (' . $year . '-' . $month . '-' . $day . ')';
    });

    // Subrouting
    $router->mount('/movies', function () use ($router) {

        // will result in '/movies'
        $router->get('/', function () {
            echo 'movies overview';
        });

        // will result in '/movies'
        $router->post('/', function () {
            echo 'add movie';
        });

        // will result in '/movies/id'
        $router->get('/(\d+)', function ($id) {
            echo 'movie id ' . htmlentities($id);
        });

        // will result in '/movies/id'
        $router->put('/(\d+)', function ($id) {
            echo 'Update movie id ' . htmlentities($id);
        });
    });

    // Thunderbirds are go!
    $router->run();

// EOF
