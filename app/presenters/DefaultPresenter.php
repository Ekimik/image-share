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
        $this->template->shareForm = $this['shareForm'];
        $this->template->simpleGallery = $this['simpleGallery'];
    }

    public function renderGallery() {
        $this->template->largeGallery = $this['largeGallery'];
    }

    public function renderInvalidAppPeriod() {
        // just show template
    }

    /**
     * @return UploadForm
     */
    protected function createComponentShareForm() {
        $fc = new FormControl();
        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/UploadForm.latte');
        $fc->setAboutBlockName('shareForm');
        $fc->setCfgParams($this->cfgParams);
        $fc->setFormName('shareForm');
        $fc->setAdapterFactory($this->adapterFactory);
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
