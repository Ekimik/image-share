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
                $this->normalizeFilename($file->name);
                $preffix = NULL;
                if (file_exists(USER_FILES_DIR . '/' . $file->name)) {
                    $preffix = time() . '_';
                }

                $file->move(USER_FILES_DIR . '/' . $preffix . $file->name);
            } catch (\Exception $e) {
                $this->addError($originalName, $e);
            }
        }
    }

}
