<?php

namespace App\Forms;

use \Nette\Application\UI\Form,
    \App\Model\Adapters\IUploadAdapter,
    \Nette\Utils\Html,
    \Nette\Utils\Strings,
    \Nette\Forms\Controls;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class UploadForm extends Form implements IUploadForm {

    /**
     * @var IUploadAdapter[]
     */
    protected $adapterChain = [];
    protected $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', '3gp', 'webm', 'mkv', 'avi'
    ];

    public function getAdapterChain() {
        if (empty($this->adapterChain)) {
            throw new \LogicException('Adapter chanin is empty, set at least one adapter');
        }

        return $this->adapterChain;
    }

    public function getAdapterFromChain($i) {
        return $this->getAdapterChain()[$i];
    }

    /**
     * @return \App\Forms\UploadForm
     */
    public function getAppForm() {
        $this->addMultiUpload('files', 'Vaše soubory (max. 10, max. velikost 32 MB)')
                ->setRequired()
                ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikosti souborů je 32MB, vaše soubory jsou moc velké, můžete '
                        . 'zkusit nahrávání rozdělit na části.', 33554432)
                ->addRule(Form::MIN_LENGTH, 'Vyberte prosím alespoň jeden soubor ke sdílení.', 1)
                ->addRule(Form::MAX_LENGTH, 'Sdílet můžete naráz pouze 10 souborů, můžete zkusit nahrávání rozdělit na části.', 10);

        $this->addSubmit('upload', 'Nahrát')
                ->setAttribute('class', 'btn btn-primary');

        $this->onSuccess[] = [$this, 'doUpload'];

        $this->setupRender();
        $this->setupControlsAppearance();
        return $this;
    }

    public function setAdapterChain(Array $chain) {
        foreach ($chain as $adapter) {
            if ($adapter instanceof IUploadAdapter) {
                $this->adapterChain[] = $adapter;
            }
        }
    }

    public function doUpload(Form $form) {
        $values = $form->getValues();

        $this->validateFiles($values['files']);
        if (!$form->hasErrors()) {
            $errors = [];

            foreach ($this->getAdapterChain() as $adapter) {
                $adapter->setFiles($values['files']);
                if (key_exists('additionalData', $values)) {
                    $adapter->setAdditionalData($values['additionalData']);
                }

                $adapter->upload();

                if ($adapter->hasErrors()) {
                    $errors = array_merge($errors, array_column($adapter->getErrors(), 'file'));
                }
            }

            if (!empty($errors)) {
                $errorsList = Html::el('ul');
                foreach ($errors as $error) {
                    $errorsList->insert(NULL, Html::el('li')->setText($error));
                }

                $msg = Html::el()
                        ->insert(NULL, 'Některé soubory se nepodařilo nahrát, zkuste to prosím s nimi později.')
                        ->insert(NULL, $errorsList);
                $this->addError($msg);
            } else {
                $this->getPresenter()->flashMessage('Děkujeme. Soubory byly úspěšně nahrány.', 'alert-success');
                $this->getPresenter()->redirect('Default:');
            }

            if ($this->hasErrors()) {
                $this->getParent()->render();
            }
        }
    }

    protected function validateFiles($files) {
        foreach ($files as $i => $file) {
            $fileExt = Strings::lower(pathinfo($file->name, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $this->allowedExtensions)) {
                $errMsg = 'Soubor %s má nepodporovaný formát.';
                $this->addError(sprintf($errMsg, $file->name));
                unset($files[$i]);
            }
        }
    }

    protected function setupControlsAppearance() {
        $usedPrimary = NULL;

        foreach ($this->getControls() as $control) {
            if ($control instanceof Controls\Button) {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                $usedPrimary = TRUE;
            } elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
                $control->getControlPrototype()->addClass('form-control');
            } elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
                $control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
            }
        }
    }

    protected function setupRender() {
        $renderer = $this->getRenderer();

        $renderer->wrappers['controls']['container'] = NULL;
        $renderer->wrappers['pair']['container'] = 'div class=form-group';
        $renderer->wrappers['error']['container'] = 'div class="errors"';
        $renderer->wrappers['error']['item'] = 'div class="alert alert-danger"';
        $renderer->wrappers['control']['container'] = 'div class="text-left"';
        $renderer->wrappers['label']['container'] = 'div class="control-label text-left"';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';
    }

}
