<?php

namespace App\Controls;

use \Nette\Utils\Finder,
    App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class RandomGalleryControl extends GalleryControl {

    protected $limit = 4;

    /**
     * @var ConfigParams
     */
    protected $cfgParams;

    public function render() {
        $template = $this->template;
        $template->setFile(__DIR__ . '/RandomGalleryControl.latte');

        $files = [];
        $i = 0;
        $searchLimit = 25 * $this->getLimit();
        foreach (Finder::findFiles($this->getFileTypes())->in(USER_FILES_DIR) as $key => $file) {
            if (!empty($this->getLimit()) && $i === $searchLimit) {
                break;
            }

            $files[] = basename($file);
            $i++;
        }

        $template->cfgParams = $this->getCfgParams();
        shuffle($files);
        $template->images = array_slice($files, 0, $this->getLimit());
        $template->render();
    }

}
