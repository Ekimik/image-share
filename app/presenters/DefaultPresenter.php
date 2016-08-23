<?php

namespace App\Presenters;

use \App\Forms\UploadForm,
    \App\Forms\FormControl;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package OneDriveUploader
 */
class DefaultPresenter extends BasePresenter {

    public function renderDefault() {
        $this->template->fbShareForm = $this['fbShareForm'];
        $this->template->oneDriveShareForm = $this['oneDriveShareForm'];
    }

    function actionFoo() {

        $this->fb->api('/1736250356617235/feed', 'POST', [
            'message' => 'Hello there fellas!',
            'access_token' => 'EAABkZBeRE0ZA0BAN2RHYyZCc8WbhRW79qbBCxSZBFuf794zmCwwV7zaA0ZBuHc0J0M9TFA8aiUXjYUwerOpOaUic9hux1u2MCDJ20HlNKiwuRKJvQJ1018LtsLS8ZCO67ZCamd2DXDKpMzTRhLtMEjmX0PSr0ZCryjBCbqQ3vyK8UgZDZD'
            ]);
        exit();
    }

    protected function createComponentFbShareForm() {
        $fc = new FormControl();
        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/UploadForm.latte');
        $fc->setAboutBlockName('fbShareForm');
        $fc->setCfgParams($this->cfgParams);
        $fc->setFormName('fbShareForm');
        return $fc;
    }

    /**
     * @return UploadForm
     */
    protected function createComponentOneDriveShareForm() {
        $fc = new FormControl();
        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/UploadForm.latte');
        $fc->setAboutBlockName('oneDriveShareForm');
        $fc->setCfgParams($this->cfgParams);
        $fc->setFormName('oneDriveShareForm');
        return $fc;
    }

}
