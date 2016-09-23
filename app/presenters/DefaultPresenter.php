<?php

namespace App\Presenters;

use \App\Forms\UploadForm,
    \App\Forms\FormControl,
    \App\Controls\SimpleGalleryControl;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class DefaultPresenter extends BasePresenter {

    public function renderDefault() {
//        $this->template->fbShareForm = $this['fbShareForm'];
        $this->template->oneDriveShareForm = $this['oneDriveShareForm'];
        $this->template->simpleGallery = $this['simpleGallery'];
    }

    public function renderGallery() {
        $this->template->largeGallery = $this['largeGallery'];
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

    protected function createComponentSimpleGallery() {
        $gallery = new SimpleGalleryControl();
        $gallery->setCfgParams($this->cfgParams);

        return $gallery;
    }

    protected function createComponentLargeGallery() {
        $gallery = new SimpleGalleryControl();
        $gallery->setCfgParams($this->cfgParams);
        $gallery->setLimit(NULL);

        return $gallery;
    }

}
