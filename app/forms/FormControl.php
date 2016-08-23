<?php

namespace App\Forms;

use \Nette\Application\UI\Control,
    \Nette\Application\UI\Form,
    \App\Model\Services\ConfigParams,
    \App\Model\Adapters\AdapterFactory;

/**
 * Description of FormControl
 *
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package OneDriveUploader
 */
class FormControl extends Control {

    /**
     * @var Form
     */
    protected $formName;

    /**
     * @var ConfigParams
     */
    protected $cfgParams;
    protected $templateFile;
    protected $aboutBlockName;

    public function render() {
        $template = $this->template;

        $template->setFile($this->getTemplateFile());
        $template->form = $this[$this->getFormName()];
        $template->aboutBlockName = $this->getAboutBlockName();
        $template->cfgParams = $this->getCfgParams();

        $template->render();
    }

    public function getCfgParams() {
        return $this->cfgParams;
    }

    public function getTemplateFile() {
        return $this->templateFile;
    }

    public function getAboutBlockName() {
        return $this->aboutBlockName;
    }

    public function setCfgParams(ConfigParams $cfgParams) {
        $this->cfgParams = $cfgParams;
        return $this;
    }

    public function setTemplateFile($templateFile) {
        $this->templateFile = $templateFile;
        return $this;
    }

    public function setAboutBlockName($aboutSubTemplate) {
        $this->aboutBlockName = $aboutSubTemplate;
        return $this;
    }

    public function getFormName() {
        return $this->formName;
    }

    public function setFormName($formName) {
        $this->formName = $formName;
        return $this;
    }

    protected function createComponentOneDriveShareForm() {
        $form = new UploadForm($this, 'oneDriveShareForm');
        $form->setAdapterChain([
            AdapterFactory::create('FileSystemUploadAdapter')
        ]);

        return $form->getAppForm();
    }

    protected function createComponentFbShareForm() {
        $form = new FbUploadForm($this, 'fbShareForm');
//        $form->setAdapterChain([
//            AdapterFactory::create('FileSystemUploadAdapter')
//        ]);

        return $form->getAppForm();
    }

}
