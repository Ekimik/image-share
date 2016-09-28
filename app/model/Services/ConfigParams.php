<?php

namespace App\Model\Services;

use \Nette\Object,
    \Nette\Utils\DateTime;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class ConfigParams extends Object {

    const APP_CODE_SOKOL_KOSETICE = 'sokol_kosetice';
    const APP_CODE_KOLEM_DOKOLA = 'kolem_dokola';

    // app itself related
    protected $appName;
    protected $appCodeName;
    protected $appYear;
    protected $appSupportMail;
    protected $appValidFrom;
    protected $appValidTo;
    // app event related
    protected $eventDate;
    protected $eventTimeFrom;
    protected $eventTimeTo;
    protected $fbEventUrl;

    /**
     * @param array $params
     */
    public function __construct(Array $params = []) {
        $this->setParams($params);
    }

    /**
     * @param array $params
     */
    public function setParams(Array $params) {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param string $param
     * @return boolean
     */
    public function isParamConfigured($param) {
        return !is_null($this->get($param));
    }

    /**
     * @return boolean
     */
    public function isAppRunPeriodValid() {
        $dateFrom = $dateTo = date('Y-m-d H:i:s');

        if ($this->isParamConfigured('appValidFrom')) {
            $dateFrom = $this->get('appValidFrom');
            $dateFrom = $dateFrom . (!$this->isFullyQualifiedPeriodPart($dateFrom) ? ' 00:00:00' : '');
        }

        if ($this->isParamConfigured('appValidTo')) {
            $dateTo = $this->get('appValidTo');
            $dateTo = $dateTo . (!$this->isFullyQualifiedPeriodPart($dateTo) ? ' 23:59:59' : '');
        }

        $now = time();
        if ($now >= strtotime($dateFrom) && $now <= strtotime($dateTo)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @param string $part - appValidFrom|appValidTo
     * @param string $format - in PHP notation
     * @return string
     */
    public function getFriendlyValidPeriodPart($part, $format) {
        return DateTime::from($this->get($part))->format($format);
    }

    /**
     * @param string $param
     * @return mixed
     */
    public function get($param) {
        return $this->$param;
    }

    /**
     * @return boolean
     */
    public function isAppCodeAllowed() {
        $code = $this->get('appCodeName');
        $allowedCodes = [self::APP_CODE_KOLEM_DOKOLA, self::APP_CODE_SOKOL_KOSETICE];

        return in_array($code, $allowedCodes);
    }

    /**
     * @param string $date
     * @return boolean
     */
    protected function isFullyQualifiedPeriodPart($date) {
        return (boolean) strpos($date, ' ');
    }

}
