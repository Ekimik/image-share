<?php

namespace App\Forms;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package OneDriveUploader
 */
interface IAppForm {

    /**
     * @return \Nette\Application\UI\Form
     */
    public function getAppForm();
}
