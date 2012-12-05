# Login/Logout with Redirect

In response to http://help.slimframework.com/discussions/questions/341-loginlogout-with-redirect I created this sample web app.

    git clone git://github.com/briannesbitt/Slim-ContextSensitiveLoginLogout.git
    cd Slim-ContextSensitiveLoginLogout
    curl -s http://getcomposer.org/installer | php
    php composer.phar install
    php -S 127.0.0.1:80   # <== assumes PHP 5.4 (built in dev server)

Launch browser to http://127.0.0.1

This application uses [route middleware](http://docs.slimframework.com/pages/routing-middleware/) for authentication and a [slim.before.dispatch hook](http://docs.slimframework.com/pages/hooks-overview/) to set a `$user` variable for all views if in fact the user is logged in.

## Public pages

From any public page you can click `Login` and it will redirect to the login page and upon successful login redirect back to the previously browsed page.  This is done partly via javascript to capture the current url on the Login click and via sessions (cookie) to store the url to redirect to.

## Private pages

This also works if you try to visit a private page as well.  If you are not logged in and try to visit `http://127.0.0.1/private/goodstuff` it will see that you are not authenticated, store that url and forward you onto the login page.  Then again upon successful login redirect you back to the requested private page.  This is all done via sessions (cookies).

## Page navigation

The page navigation only shows the Login or Logout as needed and shows private pages only after the user is logged in.

## Huh?

If you have no idea what I am talking about, first visit [Slim Framework](http://slimframework.com).