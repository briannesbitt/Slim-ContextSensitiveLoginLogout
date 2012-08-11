<?php
require 'vendor/autoload.php';

$app = new Slim();

$app->add(new Slim_Middleware_SessionCookie(array('secret' => 'myappsecret')));

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['user'])) {
            $_SESSION['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Login required');
            $app->redirect('/login');
        }
    };
};

$app->hook('slim.before.dispatch', function() use ($app) { 
   $user = null;
   if (isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
   }
   $app->view()->setData('user', $user);
});

$app->get("/", function () use ($app) {
    $app->render('index.php');
});

$app->get("/about", function () use ($app) {
   $app->render('about.php');
});

$app->get("/level/contact", function () use ($app) {
   $app->render('levelContact.php');
});

$app->get("/logout", function () use ($app) {
   unset($_SESSION['user']);
   $app->view()->setData('user', null);
   $app->render('logout.php');
});

$app->get("/login", function () use ($app) {
   $flash = $app->view()->getData('flash');

   $error = '';
   if (isset($flash['error'])) {
      $error = $flash['error'];
   }

   $urlRedirect = '/';

   if ($app->request()->get('r') && $app->request()->get('r') != '/logout' && $app->request()->get('r') != '/login') {
      $_SESSION['urlRedirect'] = $app->request()->get('r');
   }

   if (isset($_SESSION['urlRedirect'])) {
      $urlRedirect = $_SESSION['urlRedirect'];
   }

   $email_value = $email_error = $password_error = '';

   if (isset($flash['email'])) {
      $email_value = $flash['email'];
   }

   if (isset($flash['errors']['email'])) {
      $email_error = $flash['errors']['email'];
   }

   if (isset($flash['errors']['password'])) {
      $password_error = $flash['errors']['password'];
   }

   $app->render('login.php', array('error' => $error, 'email_value' => $email_value, 'email_error' => $email_error, 'password_error' => $password_error, 'urlRedirect' => $urlRedirect));
});

$app->post("/login", function () use ($app) {
    $email = $app->request()->post('email');
    $password = $app->request()->post('password');

    $errors = array();

    if ($email != "brian@nesbot.com") {
        $errors['email'] = "Email is not found.";
    } else if ($password != "aaaa") {
        $app->flash('email', $email);
        $errors['password'] = "Password does not match.";
    }

    if (count($errors) > 0) {
        $app->flash('errors', $errors);
        $app->redirect('/login');
    }

    $_SESSION['user'] = $email;

    if (isset($_SESSION['urlRedirect'])) {
       $tmp = $_SESSION['urlRedirect'];
       unset($_SESSION['urlRedirect']);
       $app->redirect($tmp);
    }

    $app->redirect('/');
});

$app->get("/private/about", $authenticate($app), function () use ($app) {
   $app->render('privateAbout.php');
});

$app->get("/private/goodstuff", $authenticate($app), function () use ($app) {
   $app->render('privateGoodStuff.php');
});


$app->run();