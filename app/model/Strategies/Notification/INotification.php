<?php

namespace App\Strategies\Notification;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
interface INotification {

    public function notify(Array $messageParams = []);

}
