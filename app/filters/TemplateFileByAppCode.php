<?php

namespace App\Filters;

use \Nette\Object;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class TemplateFileByAppCode extends Object {

    /**
     * @param string $appCodeName - see ConfigParams::APP_CODE_* constants
     * @param string $actionName
     * @return string
     */
    public function __invoke($appCodeName, $actionName) {
        if (empty($appCodeName)) {
            return sprintf('./includes/%s.latte', $actionName);
        }

        return sprintf('./includes/%s/%s.latte', $appCodeName, $actionName);
    }

}
