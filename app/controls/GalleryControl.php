<?php

namespace App\Controls;

use \Nette\Application\UI\Control,
    \Nette\Utils\Finder,
    App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class GalleryControl extends Control {

    protected $limit = NULL;
    protected $fileTypes = ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.webp'];
    protected $galleryDir;
    protected $page;

    /**
     * @var ConfigParams
     */
    protected $cfgParams;

    public function render() {
        $template = $this->template;
        $template->setFile(__DIR__ . '/GalleryControl.latte');
        $template->cfgParams = $this->getCfgParams();
        $template->images = $this->getGalleryItems();
        $template->render();
    }

    public function handlePagination($page) {
        $this->setPage((int) $page);
        $this->redrawControl();
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

    public function getGalleryDir() {
        return $this->galleryDir;
    }

    public function setGalleryDir($dir) {
        $this->galleryDir = $dir;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        if (empty($page) || $page === 1 || $page < 0) {
            $page = 1;
        }

        $this->page = $page;
    }

    public function getTotalPagesCount() {
        $filesCount = Finder::findFiles($this->getFileTypes())->in($this->getGalleryDir())->count();
        $perPage = $this->getLimit();
        if ($perPage === NULL) {
            return 0;
        }

        return ceil($filesCount / $perPage);
    }

    protected function getGalleryItems() {
        $files = [];
        $i = 0;
        $limit = $this->getLimit();
        $offset = ($this->getPage() - 1) * $limit;

        foreach (Finder::findFiles($this->getFileTypes())->in($this->getGalleryDir()) as $key => $file) {
            if ($i < $offset) {
                $i++;
                continue;
            }

            if (!empty($limit) && count($files) === $limit) {
                break;
            }

            $files[] = basename($file);
        }

        return $files;
    }

}
