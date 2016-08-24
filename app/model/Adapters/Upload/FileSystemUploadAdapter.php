<?php

namespace App\Model\Adapters;

use \Nette\Utils\Strings;

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
                $extension = Strings::lower(pathinfo($file->name, PATHINFO_EXTENSION));
                $filename = pathinfo($file->name, PATHINFO_FILENAME);
                $filename = $this->normalizeFilename($filename);

                $preffix = time() . rand(0, 100) . '_';
                $file->move(USER_FILES_DIR . '/' . $preffix . $filename . '.' . $extension);
            } catch (\Exception $e) {
                $this->addError($originalName, $e);
            }
        }
    }

}
