<?php

namespace App\Presenters;

use \Nette\Application\UI\Presenter,
    \App\Model\Services\ConfigParams,
    \App\Model\Adapters\AdapterFactory;

/**
 * Base presenter for all application presenters.
 * @package ImageShare
 */
abstract class BasePresenter extends Presenter {

    /**
     * @var ConfigParams
     */
    protected $cfgParams;

    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    public function injectServices(ConfigParams $cfgParams) {
        $this->cfgParams = $cfgParams;
    }

    public function injectFactories(AdapterFactory $af) {
        $this->adapterFactory = $af;
    }

    protected function startup() {
        parent::startup();
        $this->template->cfgParams = $this->cfgParams;

        // check app run period
        if (!$this->cfgParams->isAppRunPeriodValid() && $this->getAction() !== 'invalidAppPeriod') {
            $this->redirect('Default:invalidAppPeriod');
        }
    }

}
