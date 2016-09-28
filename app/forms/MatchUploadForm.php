<?php

namespace App\Forms;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class MatchUploadForm extends UploadForm {

    protected $matches = [];

    public function getAppForm() {
        $this->addContainer('additionalData'
                )->addSelect('directory', 'Vyberte zápas', $this->matches)
                ->setRequired('Vyberte prosím některý ze zápasů.');

        return parent::getAppForm();
    }

    /**
     * @param array $matches
     * @see matches.json file in config direcotry for format
     */
    public function setMatches(Array $matches) {
        // process parsed matches JSON config file
        foreach ($matches as $match) {
            $this->matches[$match->value] = $match->text;
        }
    }

}
