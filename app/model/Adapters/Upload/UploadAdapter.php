<?php

namespace App\Model\Adapters;

use \Nette\Http\FileUpload,
    \Nette\Utils\Strings,
    \App\Strategies\Notification\INotification;

/**
 * Base upload adapter
 *
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
abstract class UploadAdapter implements IUploadAdapter {

    /** @var FileUpload[] */
    protected $files;
    protected $additionalData = [];
    protected $errors = [];

    /**
     * @var INotification
     */
    protected $notificationAbility;

    public function getAdditionalData() {
        return $this->additionalData;
    }

    /**
     * @return FileUpload[]
     */
    public function getFiles() {
        return $this->files;
    }

    /**
     * @return INotification
     */
    public function getNotificationAbility() {
        return $this->notificationAbility;
    }

    /**
     * @param array $data
     */
    public function setAdditionalData($data) {
        $this->additionalData = $data;
    }

    public function setFiles($files) {
        $this->files = $files;
    }

    /**
     * @param INotification $notification
     */
    public function setNotificationAbility(INotification $notification) {
        $this->notificationAbility = $notification;
    }

    public function normalizeFilename($filename) {
        return Strings::webalize($filename);
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function clearErrors() {
        $this->errors = [];
    }

    /**
     * @param string $file
     * @param string|\Exception $error
     */
    public function addError($file, $error) {
        $this->errors[] = ['file' => $file, 'error' => $error];
    }

}
