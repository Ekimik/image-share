<?php

namespace App\Presenters;

use \App\Forms\FormControl,
    \App\Controls\RandomGalleryControl,
    \App\Controls\GalleryControl,
    \App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class DefaultPresenter extends BasePresenter {

    public function renderDefault() {
        $appCode = $this->cfgParams->get('appCodeName');
        if ($appCode === ConfigParams::APP_CODE_KOLEM_DOKOLA) {
            $this->template->shareForm = $this['shareForm'];
            $this->template->kolemDokolaSimpleGallery = $this['kolemDokolaSimpleGallery'];
        } else if ($appCode === ConfigParams::APP_CODE_SOKOL_KOSETICE) {
            $this->template->matchShareForm = $this['matchShareForm'];
        }
    }

    public function renderGallery() {
        $appCode = $this->cfgParams->get('appCodeName');
        if ($appCode === ConfigParams::APP_CODE_KOLEM_DOKOLA) {
            $this->template->kolemDokolaLargeGallery = $this['kolemDokolaLargeGallery'];
        } else if ($appCode === ConfigParams::APP_CODE_SOKOL_KOSETICE) {

        }
    }

    public function renderInvalidAppPeriod() {
        // just show template
    }

    /**
     * @return FormControl
     */
    protected function createComponentShareForm() {
        $fc = new FormControl();
        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/' . $this->cfgParams->get('appCodeName') . '/UploadForm.latte');
        $fc->setAboutBlockName('shareForm');
        $fc->setCfgParams($this->cfgParams);
        $fc->setFormName('shareForm');
        $fc->setAdapterFactory($this->adapterFactory);
        return $fc;
    }

    /**
     * @return FormControl
     */
    protected function createComponentMatchShareForm() {
        $fc = new FormControl();
        $fc->setTemplateFile(FORM_TEMPLATES_DIR . '/' . $this->cfgParams->get('appCodeName') . '/MatchUploadForm.latte');
        $fc->setCfgParams($this->cfgParams);
        $fc->setFormName('matchShareForm');
        $fc->setAdapterFactory($this->adapterFactory);
        return $fc;
    }

    protected function createComponentKolemDokolaSimpleGallery() {
        $gallery = new RandomGalleryControl();
        $gallery->setCfgParams($this->cfgParams);
        $gallery->setGalleryDir(USER_FILES_DIR_NAME);

        return $gallery;
    }

    protected function createComponentKolemDokolaLargeGallery() {
        $gallery = new GalleryControl();
        $gallery->setCfgParams($this->cfgParams);
        $gallery->setLimit(2);
        $gallery->setGalleryDir(USER_FILES_DIR_NAME);

        return $gallery;
    }

}
