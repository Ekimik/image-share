<?php

namespace App\Forms;

use \Nette\Application\UI\Control,
    \Nette\Application\UI\Form,
    \App\Model\Services\ConfigParams,
    \App\Model\Adapters\AdapterFactory,
    \Nette\Utils\Json;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class FormControl extends Control {

    /**
     * @var Form
     */
    protected $formName;

    /**
     * @var AdapterFactory
     */
    protected $af;

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

    public function setAdapterFactory(AdapterFactory $af) {
        $this->af = $af;
    }

    /**
     * @return UploadForm
     */
    protected function createComponentShareForm() {
        $form = new UploadForm($this, 'shareForm');
        $form->setAdapterChain([
            $this->af->create('FileSystemUploadAdapter')
        ]);

        return $form->getAppForm();
    }

    /**
     * @return MatchUploadForm
     */
    protected function createComponentMatchShareForm() {
        $form = new MatchUploadForm($this, 'matchShareForm');
        $form->setAdapterChain([
            $this->af->create('FileSystemUploadAdapter')
        ]);
        $form->setMatches(Json::decode(file_get_contents(CONFIG_DIR . '/matches.json')));

        return $form->getAppForm();
    }

}
