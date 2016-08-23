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
//        $this->template->fbShareForm = $this['fbShareForm'];
        $this->template->oneDriveShareForm = $this['oneDriveShareForm'];
    }

//    protected function createComponentFbShareForm() {
//        $fc = new FormControl();
//        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/UploadForm.latte');
//        $fc->setAboutBlockName('fbShareForm');
//        $fc->setCfgParams($this->cfgParams);
//        $fc->setFormName('fbShareForm');
//        return $fc;
//    }

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
