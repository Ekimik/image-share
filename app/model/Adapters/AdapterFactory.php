<?php

namespace App\Model\Adapters;

use \Nette\Object,
    \Nette\Utils\Strings,
    \App\Model\Exceptions\InvalidArgumentException,
    \App\Strategies\Notification\EmailNotification,
    \App\Strategies\Notification\NullNotification,
    \App\Model\Services\ConfigParams;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class AdapterFactory extends Object {

    /**
     * @var ConfigParams
     */
    protected $cfg;

    public function __construct(ConfigParams $cfg) {
        $this->cfg = $cfg;
    }

    public function create($name) {
        $name = Strings::lower($name);
        $adapter = NULL;

        if ($name === 'filesystemuploadadapter') {
            $adapter = new FileSystemUploadAdapter();
        } else {
            throw new InvalidArgumentException(sprintf('Unknown adapter %s', $name));
        }

        $this->configureNotifications($adapter);
        return $adapter;
    }

    /**
     * @param IAdapter $adapterInstance
     */
    protected function configureNotifications($adapterInstance) {
        $notificationSettings = $this->cfg->get('notifications');
        $codeName = $this->cfg->get('appCodeName');
        $adapterName = $adapterInstance->getAdapterName();
        if (!empty($notificationSettings) && !is_null($codeName) && isset($notificationSettings[$codeName][$adapterName])) {
            $from = $notificationSettings[$codeName][$adapterName]['from'];
            $to = $notificationSettings[$codeName][$adapterName]['to'];
            $subject = $notificationSettings[$codeName][$adapterName]['subject'];
            $message = $notificationSettings[$codeName][$adapterName]['message'];
            $adapterInstance->setNotificationAbility(new EmailNotification($from, $to, $subject, $message));
        } else {
            $adapterInstance->setNotificationAbility(new NullNotification());
        }
    }

}
