<?php
/**
* @author      Laurent Jouanneau
* @copyright   2015-2017 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

/**
 */
class jminifyModuleInstaller extends \Jelix\Installer\ModuleInstaller {

    function installEntrypoint(\Jelix\Installer\EntryPoint $entryPoint) {

        if (!$this->firstExec('config')) {
            return;
        }
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

        $entrypoint = $config->getValue('minifyEntryPoint','jResponseHtml', null, true);
        if ($entrypoint === null) {
            $config->setValue('minifyEntryPoint','minify.php','jResponseHtml', null, true);
            $entrypoint = 'minify.php';
        }

        if (!file_exists(jApp::wwwPath($entrypoint))) {
            $this->copyFile('files/minify.php', jApp::wwwPath($entrypoint));
        }
        if (!file_exists(jApp::appConfigPath('minifyConfig.php'))) {
            $this->copyFile('files/minifyConfig.php', jApp::appConfigPath('minifyConfig.php'));
        }
        if (!file_exists(jApp::appConfigPath('minifyGroupsConfig.php'))) {
            $this->copyFile('files/minifyGroupsConfig.php', jApp::appConfigPath('minifyGroupsConfig.php'));
        }

    }
}
