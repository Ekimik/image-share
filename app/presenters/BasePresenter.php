<?php

namespace App\Presenters;

use \Nette\Application\UI\Presenter,
    \App\Model\Services\ConfigParams,
    \App\Model\Adapters\AdapterFactory,
    \App\Filters\TemplateFileByAppCode;

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
        // base template variables
        $this->template->cfgParams = $this->cfgParams;
        $this->template->appCodeName = $this->cfgParams->get('appCodeName');
        $this->template->presenterName = $this->getName();
        $this->template->actionName = $this->getAction();

        // check app run period
        if (!$this->cfgParams->isAppRunPeriodValid() && $this->getAction() !== 'invalidAppPeriod') {
            $this->redirect('Default:invalidAppPeriod');
        }

        // check if app code name is configured
        if (!$this->cfgParams->isParamConfigured('appCodeName') && $this->getAction(TRUE) !== ':Default:default') {
            $this->redirect('Default:default');
        }

        // custom latte filters
        $this->template->addFilter('templateByCode', new TemplateFileByAppCode());
    }

}
