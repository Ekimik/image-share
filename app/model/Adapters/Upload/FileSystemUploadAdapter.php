<?php

namespace App\Model\Adapters;

use \Nette\Utils\Strings,
    \Nette\Utils\FileSystem;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class FileSystemUploadAdapter extends UploadAdapter {

    public function upload() {
        $files = $this->getFiles();
        foreach ($files as $file) {
            $originalName = $file->name;

            try {
                $extension = Strings::lower(pathinfo($file->name, PATHINFO_EXTENSION));
                $filename = pathinfo($file->name, PATHINFO_FILENAME);
                $filename = $this->normalizeFilename($filename);

                $dir = $this->getDirectory();
                if (!is_dir($dir)) {
                    FileSystem::createDir($dir);
                }

                $preffix = time() . rand(0, 100) . '_';
                $file->move($dir . '/' . $preffix . $filename . '.' . $extension);
            } catch (\Exception $e) {
                $this->addError($originalName, $e);
            }
        }
    }

    protected function getDirectory() {
        $ad = $this->getAdditionalData();
        $specificDir = NULL;
        if (key_exists('directory', $ad)) {
            $specificDir = '/' . $ad['directory'];
        }

        return USER_FILES_DIR . $specificDir;
    }

}
