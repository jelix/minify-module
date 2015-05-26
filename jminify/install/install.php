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

        $plugins = $this->config->getValue('plugins','jResponseHtml');
        if (strpos($plugins, 'minify') === false) {
            $plugins .= ',minify';
            $this->config->setValue('plugins',$plugins,'jResponseHtml', null, true);
        }

        if (null == $this->config->getValue('minifyCSS','jResponseHtml', null, true)) {
            $this->config->setValue('minifyCSS','off','jResponseHtml', null, true);
        }
        if (null == $this->config->getValue('minifyJS','jResponseHtml', null, true)) {
            $this->config->setValue('minifyJS','on','jResponseHtml', null, true);
        }
        if (null == $this->config->getValue('minifyExcludeCSS','jResponseHtml', null, true)) {
            $this->config->setValue('minifyExcludeCSS','','jResponseHtml', null, true);
        }
        if (null == $this->config->getValue('minifyExcludeJS','jResponseHtml', null, true)) {
            $this->config->setValue('minifyExcludeJS','jelix/wymeditor/jquery.wymeditor.js','jResponseHtml', null, true);
        }

        $entrypoint = $this->config->getValue('minifyEntryPoint','jResponseHtml', null, true);
        if ($entrypoint === null) {
            $this->config->setValue('minifyEntryPoint','minify.php','jResponseHtml', null, true);
            $entrypoint = 'minify.php';
        }

        if (!file_exists(jApp::wwwPath($entrypoint))) {
            $this->copyFile('files/minify.php', jApp::wwwPath($entrypoint));
        }

    }
}
