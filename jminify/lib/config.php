<?php

require(MINIFY_MIN_DIR . '/config.php');

if (file_exists(\jApp::appSystemPath('minifyConfig.php'))) {
    require(\jApp::appSystemPath('minifyConfig.php'));
}
\Jelix\Minify\MinifySetup::initOptions();
