<?php

namespace App\Model\Services;

use \Nette\Object;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class ConfigParams extends Object {

    protected $appName;
    protected $appYear;
    protected $appSupportMail;
    protected $eventDate;
    protected $eventTimeFrom;
    protected $eventTimeTo;
    protected $fbEventUrl;

    /**
     * @param array $params
     */
    public function __construct(Array $params) {
        $this->setParams($params);
    }

    public function setParams(Array $params) {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    public function get($param) {
        return $this->$param;
    }

}
