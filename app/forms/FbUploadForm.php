<?php

namespace App\Forms;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class FbUploadForm extends UploadForm {

    public function getAppForm() {
        $this->addText('name', 'Vaše jméno')
                ->setRequired()
                ->setAttribute('placeholder', 'Vaše jméno nebo přezdívka');

        return parent::getAppForm();
    }

}
