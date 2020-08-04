<?php
/**
 * ParentController
 *
 * @package    BASEs
 * @subpackage MVC/JSON
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\MVC\TemplateEngines\JSON;

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
     * @var string $code language-country-code
     */
    protected string $code = "";

    /**
     * ParentController constructor.
     *
     * @param string $code language-country-code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     *
     * @param array $data
     */
    protected function createJsonOutput(array $data): void
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($data);
    }
}