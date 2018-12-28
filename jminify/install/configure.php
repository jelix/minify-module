<?php
/**
 * @author      Laurent Jouanneau
 * @copyright   2018 Laurent Jouanneau
 * @link        http://www.jelix.org
 * @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
 */
use \Jelix\Installer\Module\API\ConfigurationHelpers;

class jminifyModuleConfigurator extends \Jelix\Installer\Module\Configurator {

    public function getDefaultParameters()
    {
        return array(
            'eps'=>array('index')
        );
    }

    public function configure(ConfigurationHelpers $helpers) {

        $this->parameters['eps'] = $helpers->cli()->askEntryPoints(
            'Select entry points on which to setup jminify',
            'classic',
            true
        );

        $helpers->copyFile('files/minifyConfig.php', 'config:minifyConfig.php');
        $helpers->copyFile('files/minifyGroupsConfig.php', 'config:minifyGroupsConfig.php');

        foreach($this->getParameter('eps') as $epId) {
            $this->configureEntryPoint($helpers, $epId);
        }
    }

    public function configureEntryPoint(ConfigurationHelpers $helpers, $epId) {
        $entryPoint = $helpers->getEntryPointsById($epId);
        $config = $entryPoint->getConfigIni();

        $plugins = $config->getValue('plugins','jResponseHtml');
        if (strpos($plugins, 'minify') === false) {
            $plugins .= ',minify';
            $config->setValue('plugins',$plugins,'jResponseHtml', null, true);
        }

        if (null == $config->getValue('minifyCSS','jResponseHtml', null, true)) {
            $config->setValue('minifyCSS','off','jResponseHtml', null, true);
        }
        if (null == $config->getValue('minifyJS','jResponseHtml', null, true)) {
            $config->setValue('minifyJS','on','jResponseHtml', null, true);
        }
        if (null == $config->getValue('minifyExcludeCSS','jResponseHtml', null, true)) {
            $config->setValue('minifyExcludeCSS','','jResponseHtml', null, true);
        }
        if (null == $config->getValue('minifyExcludeJS','jResponseHtml', null, true)) {
            $config->setValue('minifyExcludeJS','jelix/wymeditor/jquery.wymeditor.js','jResponseHtml', null, true);
        }

        $entrypointMinify = $config->getValue('minifyEntryPoint','jResponseHtml', null, true);
        if ($entrypointMinify === null) {
            $config->setValue('minifyEntryPoint','minify.php','jResponseHtml', null, true);
            $entrypointMinify = 'minify.php';
        }

        if (!file_exists(jApp::wwwPath($entrypointMinify))) {
            $this->copyFile('files/minify.php', jApp::wwwPath($entrypointMinify));
        }
    }

    public function unconfigure(ConfigurationHelpers $helpers) {

        $helpers->removeFile('config:minifyConfig.php');
        $helpers->removeFile('config:minifyGroupsConfig.php');

        foreach($this->getParameter('eps') as $epId) {
            $this->unconfigureEntryPoint($epId);
        }
    }

    public function unconfigureEntryPoint(ConfigurationHelpers $helpers, $epId) {
        $entryPoint = $helpers->getEntryPointsById($epId);
        $config = $entryPoint->getConfigIni();

        $plugins = $config->getValue('plugins','jResponseHtml');
        if (strpos($plugins, 'minify') !== false) {
            $plugins = str_replace('minify', '', $plugins);
            $plugins = str_replace(',,', ',', $plugins);
            $config->setValue('plugins',$plugins,'jResponseHtml', null, true);
        }

        $config->removeValue('minifyCSS', 'jResponseHtml');
        $config->removeValue('minifyJS','jResponseHtml');
        $config->removeValue('minifyExcludeCSS','jResponseHtml');
        $config->removeValue('minifyExcludeJS','jResponseHtml');

        $entrypointMinify = $config->getValue('minifyEntryPoint','jResponseHtml', null, true);
        if ($entrypointMinify !== null) {
            $config->removeValue('minifyEntryPoint','jResponseHtml');
        }

        if (file_exists(jApp::wwwPath($entrypointMinify))) {
            unlink(jApp::wwwPath($entrypointMinify));
        }
    }

}