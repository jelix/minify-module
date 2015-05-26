This is a module for Jelix, providing Minify features for HTML response objects.

[Minify](http://code.google.com/p/minify/) is a library which allow to
concatenate and minify CSS and JS files. It improves performance during the load
of the page. This module provides plugins to integrate it into a Jelix application.

This module is for Jelix 1.7.x and higher. See the jelix/jelix repository to see
its history before Jelix 1.7.


## Installation


Install it by hands like any other Jelix modules, or use Composer if you installed
Jelix 1.7+ with Composer.

In your project:

```
composer require "jelix/minify-module"
```

Then declare the module into the configuration of your application

```ini
[modules]

jminify.access=1
```

Then run the installer

```
php your_app/install/installer.php
```

You can use the module.

## Using the module


In the configuration file of the application, after the installation you should
have these parameters in the ```jResponseHtml``` section:

```ini
[jResponseHtml]
plugins = minify

;concatenate and minify CSS and/or JS files :
minifyCSS = off # [on|off] : concatenate/minify CSS files
minifyJS = off # [on|off] : concatenate/minify JS files

; list of filenames (no path) which shouldn't be minified - coma separated :
minifyExcludeCSS = "file1.css,file2.css"
minifyExcludeJS = "jelix/wymeditor/jquery.wymeditor.js"

; bootstrap file for Minify. indicate a relative path to the basePath.
minifyEntryPoint = minify.php
```

With ```minifyCSS``` and ```minifyJS``` you activate the "minification". You
can indicate files to **NOT** minify in ```minifyExcludeCSS``` and
```minifyExcludeJS```. Keep the file name ```jelix/wymeditor/jquery.wymeditor.js``` (which is
bundled into Jelix) in ```minifyExcludeJS```. Wymeditor doesn't like to be concatenated with other files.

Indicated path should be

- relative to the base path of the application (without a leading /)
- or relative to the domain name (with a leading /)

Don't indicate full URL (with ```http://```...), they are automatically excluded.

The module installer copy a script ```minify.php``` in your ```www/``` directory. There
are some options in this file you can set to configure Minify (read the documentation of
Minify). If you want to choose an other name for this script, indicate its name into the
option ```minifyEntryPoint```.

## unit tests

Unit tests are in Testapp, in the jelix/jelix repository.
