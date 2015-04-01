# CodeIgniter 3.0 on OpenShift #
This QuickStart was created to make it easy to get started with CodeIgniter 3.0 
on OpenShift.

[CodeIgniter](http://www.codeigniter.com/) is a powerful PHP 
framework with a very small footprint, built for developers who need a simple 
and elegant toolkit to create full-featured web applications. CodeIgniter 3.0 is
the current version of the framework. There have been a number of refinements 
since version 2.x, notably with the database and session handling. Development 
of this version is ongoing.

The simplest way to install this application is to use the [OpenShift
QuickStart](https://hub.openshift.com/quickstarts/123-codeigniter-3-0). If 
you'd like to install it manually, follow [these directions](#manual-installation).

## OpenShift Considerations ##
These are some special considerations you may need to keep in mind when running 
your application on OpenShift using this QuickStart.

### .htaccess Configuration ###
The `.htaccess` file has been pre-configured to remove trailing slashes and 
index.php from URLs (based on typical CodeIgniter best-practices).

### Handling Assets (CSS, fonts, images, and JavaScript) ###
Deciding where to store your asset files isn't clear with CodeIgniter.
Accordingly, I've pre-configured this QuickStart with an `assets` directory for
you to store your custom fonts, images, javascripts, and stylesheets.

I also extended the base HTML and URL helper files to make using assets stored 
in the assets directories easy.

#### URL Helper ####
The URL Helper file contains functions that assist in working with URLs.

_ADDED_ **Asset URL** - returns the URL of your assets directory. Example:

    echo asset_url();
    // http://example.com/assets/

Or, with a URI:

    echo asset_url('images/logo.png'); 
    // http://example.com/assets/images/logo.png

#### HTML Helper ####
The HTML Helper file contains functions that assist in working with HTML.

_UPDATED_ **Img** - Lets you create HTML <img /> tags. Updated to automatically 
prepend 'assets/images/' to path when necessary. Example:

    echo img('picture.jpg');
    // <img src="http://example.com/assets/images/picture.jpg" />

_UPDATED_ **Link Tag** - Lets you create HTML <link /> tags (mostly for stylesheets). Updated 
to automatically prepend 'assets/stylesheets/' to path when necessary and 
rel="stylesheet". 
Example:

    echo link_tag('styles.css');
    // <link src="http://example.com/assets/stylesheets/styles.css" rel="stylesheet" type="text/css" />

_ADDED_ **Script Tag** - Lets you create HTML <script /> tags. Automatically
prepends 'assets/javascripts/' to path when necessary. Example:

    echo script_tag('jquery.js');
    // <script type="text/javascript" src="http://example.com/assets/javascripts/jquery.js"></script>

### Local vs. Remote Development ###
This CodeIgniter QuickStart provides separate configuration files for both local 
and remote development, found in `application/config/local` and 
`application/config` respectively.

#### Local Development ####
When developing locally, this QuickStart will set the CodeIngiter `ENVIRONMENT` 
to 'local' development mode.

Configuration files for working locally can be found at 
`application/config/local`. See the CodeIngiter user guide for more information 
on how CodeIgniter handles 
[Multiple Environments](http://www.codeigniter.com/userguide3/general/environments.html).

#### Remote Development ####
Your application is configured to automatically use your OpenShift MySQL or 
PostgreSQL database in when deployed on OpenShift by making use of
[OpenShift Environment Variables](https://developers.openshift.com/en/managing-environment-variables.html).

The CodeIgniter `base_url` and `encryption_key` have also been configured to 
automatically draw from OpenShift Environment variables.

OpenShift provides a directory for data that requires persistent storage.
Accordingly, the CodeIgniter `cache_path`, database `cachedir`,  and 
`session_save_path` have been set to use this directory for storage.

Finally, the CodeIgniter `ENVIRONMENT` will be set automatically in 
production on OpenShift to match the value of the `APPLICATION_ENV` OpenShift 
Environment variable, set to 'production' by default.

##### Development Mode #####
When you develop your CodeIgniter application on OpenShift, you can also enable 
the 'development' environment by setting the `APPLICATION_ENV` environment 
variable using the `rhc` client, like:

```
$ rhc env set APPLICATION_ENV=development -a <app-name>
```

Then, restart your application:

```
$ rhc app restart -a <app-name>
```

If you do so, OpenShift will run your application under 'development' mode.
In development mode, your application will:

* Set CodeIgniter's `ENVIRONMENT` to 'development'
* Show more detailed errors in browser
* Display startup errors
* Enable the [Xdebug PECL extension](http://xdebug.org/)
* Enable [APC stat check](http://php.net/manual/en/apc.configuration.php#ini.apc.stat)
* Ignore your composer.lock file

Using the development environment can help you debug problems in your application
in the same way as you do when developing on your local machine. However, we 
strongly advise you not to run your application in this mode in production.

### Log Files ###
Your application is configured to use the OpenShift log directory. You can use
the `rhc tail` command to stream the latest log file entries:

```
rhc tail -a <APP_NAME>
```

To stop tailing the logs, press *Ctrl + c*.

### Composer ###
CodeIgniter 3 [provides support for Composer](http://www.codeigniter.com/userguide3/general/autoloader.html)
to auto-load additional packages. The value of `composer_autoload` is set to 
`FALSE` by default, however, this QuickStart is pre-configured to allow you to 
enable this feature and use OpenShift's built-in suppoert for Composer.

When the application is pushed, `composer install` is automatically executed 
over the root directory. See [PHP Markers](https://developers.openshift.com/en/php-markers.html) 
for more details on the **use_composer** marker file.

## Manual Installation ##

1. Create an account at https://www.openshift.com/

1. Create a CodeIgniter application:

    ```
    rhc app create ciapp php-5.4 mysql-5.5 --from-code=https://github.com/luciddreamz/codeigniter
    ```
    or

    ```
    rhc app create ciapp php-5.4 postgresql-9.2 --from-code=https://github.com/luciddreamz/codeigniter
    ```

## Additional Resources ##
Documentation for the CodeIgniter framework can be found on the 
[CodeIgniter website](http://www.codeigniter.com/userguide3/). Check out 
OpenShift's [Developer Portal](https://developers.openshift.com/en/php-overview.html) 
for help running PHP on OpenShift.