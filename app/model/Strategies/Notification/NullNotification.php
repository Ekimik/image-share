<?php

namespace App\Strategies\Notification;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class NullNotification implements INotification {

    public function notify(Array $messageParams = []) {

    }

}
