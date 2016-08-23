<?php

namespace App\Controls;

use \Nette\Application\UI\Control,
    \Nette\Utils\Finder,
    App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package OneDriveUploader
 */
class SimpleGalleryControl extends Control {

    protected $limit = 4;
    protected $fileTypes = ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.webp'];

    /**
     * @var ConfigParams
     */
    protected $cfgParams;

    public function render() {
        $template = $this->template;
        $template->setFile(__DIR__ . '/SimpleGalleryControl.latte');

        $files = [];
        $i = 0;
        $searchLimit = 100;
        foreach (Finder::findFiles($this->getFileTypes())->in(USER_FILES_DIR) as $key => $file) {
            if (!empty($this->getLimit()) && $i === $searchLimit) {
                break;
            }

            $files[] = basename($file);
            $i++;
        }

        $template->cfgParams = $this->getCfgParams();

        shuffle($files);
        if (!empty($this->getLimit())) {
            $template->images = array_slice($files, 0, $this->getLimit());
        }
        $template->render();
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getFileTypes() {
        return $this->fileTypes;
    }

    public function getCfgParams() {
        return $this->cfgParams;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function setFileTypes($fileTypes) {
        $this->fileTypes = $fileTypes;
        return $this;
    }

    public function setCfgParams(ConfigParams $cfgParams) {
        $this->cfgParams = $cfgParams;
        return $this;
    }

}
