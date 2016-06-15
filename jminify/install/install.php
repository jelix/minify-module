<?php
/**
* @author      Laurent Jouanneau
* @copyright   2015 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

/**
 */
class jminifyModuleInstaller extends jInstallerModule {

    function install() {

        if (!$this->firstExec('config')) {
            return;
        }
        $config = $this->entryPoint->getMainConfigIni();

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
    }
}
