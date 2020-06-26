<?php
/**
 * ParentController
 *
 * @package    BASEs
 * @subpackage MVC/Smarty
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\MVC\TemplateEngines\Smarty;

use BASE\Config;
use BASE\MVC\TemplateEngines\Smarty\Plugins\Link;
use Exception;
use RuntimeException;
use Smarty;
use SmartyException;

/**
 * Class ParentController
 *
 * @package    BASE
 * @subpackage MVC
 * @version    v0.
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */
class ParentController implements \BASE\MVC\TemplateEngines\ParentController
{
    /**
     * @var Smarty $Smarty Instance of Smarty template engine
     */
    protected Smarty $Smarty;

    /**
     * @var string $code language-country-code
     */
    protected string $code = "";

    /**
     * ParentController constructor.
     *
     * @param string $code language-country-code
     *
     * @throws SmartyException
     */
    public function __construct(string $code)
    {
        $this->code = $code;

        /* @var $this ->Smarty \Smarty */
        $this->Smarty = new Smarty();

        $this->Smarty->setTemplateDir(Config::getAppDir() . "public/views/templates/");
        $this->Smarty->setCacheDir(Config::getAppDir() . "public/views/cache/");
        $this->Smarty->setConfigDir(Config::getAppDir() . "public/views/configs/");
        $this->Smarty->setCompileDir(Config::getAppDir() . "public/views/templates_c/");

        $this->loadPlugins();
    }

    /**
     * Registers necessary smarty plugins.
     *
     * @return void
     * @throws SmartyException
     */
    private function loadPlugins()
    {
        $this->Smarty->registerObject('Link', new Link());
    }

    /**
     *
     * Load a template and config related to the called class und function (given as parameter).
     * Uses the language-country-code for the config file.
     *
     * @param string $functionName Should be the name of the function that called this function
     *
     * @throws Exception
     */
    protected function displayTemplates(string $functionName)
    {
        $class = get_called_class();
        $class = str_replace("BASE\Controller\\", "", $class);
        $class = str_replace("\\", "/", $class);

        $this->loadConfig($class . "/" . $functionName . ".conf");

        $tpl = $class . "/" . $functionName . ".tpl";

        try {
            $this->Smarty->display($tpl);
        } catch (SmartyException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Loads the given config file.
     * First loads the config file for the default local code, defined in the base.xml.
     * After that loads the config file of the current local code, if different. The current config file
     * overwrites the text-vars from the default config file.
     *
     * @param string $configFile Relative path of the config file that you be loaded
     *
     * @return void
     */
    protected function loadConfig(string $configFile): void
    {
        /**
         * default local code file
         */

        $defaultCode = Config::getHostParameter("localCode");
        if (is_string($defaultCode)) {
            $defaultConfigFile = $defaultCode . "/" . $configFile;

            if (file_exists($this->Smarty->getConfigDir()[0] . $defaultConfigFile)) {
                $this->Smarty->configLoad($defaultConfigFile);
            }

            /**
             * current local code file
             */
            if ($defaultCode != $this->code) {
                $currentConfigFile = $this->code . "/" . $configFile;

                if (file_exists($this->Smarty->getConfigDir()[0] . $currentConfigFile)) {
                    $this->Smarty->configLoad($currentConfigFile);
                }
            }
        }
    }
}