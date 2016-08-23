<?php

namespace App\Presenters;

use \Nette\Application\UI\Presenter,
    \App\Model\Services\ConfigParams,
    \Kdyby\Facebook\Facebook;

/**
 * Base presenter for all application presenters.
 * @package OneDriveUploader
 */
abstract class BasePresenter extends Presenter {

    /**
     * @var ConfigParams
     */
    protected $cfgParams;

    /**
     *
     * @var Facebook
     */
    protected $fb;

    public function injectServices(ConfigParams $cfgParams, Facebook $fb) {
        $this->cfgParams = $cfgParams;
        $this->fb = $fb;
    }

    protected function startup() {
        parent::startup();
        $this->template->cfgParams = $this->cfgParams;
    }

}
