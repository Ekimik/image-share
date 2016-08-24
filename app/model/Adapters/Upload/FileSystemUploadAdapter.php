<?php

namespace App\Model\Adapters;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package OneDriveUploader
 */
class FileSystemUploadAdapter extends UploadAdapter {

    public function upload() {
        $files = $this->getFiles();
        foreach ($files as $file) {
            $originalName = $file->name;

            try {
                $filename = $this->normalizeFilename($file->name);
                $preffix = time() . rand(0, 100) .'_';
                $file->move(USER_FILES_DIR . '/' . $preffix . $filename);
            } catch (\Exception $e) {
                $this->addError($originalName, $e);
            }
        }
    }

}
