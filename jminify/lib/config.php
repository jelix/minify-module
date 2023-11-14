<?php
use \Jelix\Core\App;
require(MINIFY_MIN_DIR . '/config.php');

if (file_exists(App::appSystemPath('minifyConfig.php'))) {
    require(App::appSystemPath('minifyConfig.php'));
}
\Jelix\Minify\MinifySetup::initOptions();
