<?php

require(MINIFY_MIN_DIR . '/config.php');

if (file_exists(\jApp::appConfigPath('minifyConfig.php'))) {
    require(\jApp::appConfigPath('minifyConfig.php'));
}
\Jelix\Minify\MinifySetup::initOptions();
