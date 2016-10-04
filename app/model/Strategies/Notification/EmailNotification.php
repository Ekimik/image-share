<?php

namespace App\Strategies\Notification;

use \Nette\Mail\SendmailMailer,
    \Nette\Mail\Message;

/**
 * @author Jan Jíša <j.jisa@seznam.cz>
 * @package ImageShare
 */
class EmailNotification implements INotification {

    /**
     * @var SendmailMailer
     */
    protected $mailer;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @param string $from
     * @param array $to
     * @param string $subject
     * @param string $message
     */
    public function __construct($from, Array $to, $subject, $message) {
        $this->mailer = new SendmailMailer();
        $this->message = new Message();

        $this->message->setFrom($from);
        $this->message->setSubject($subject);
        $this->message->setBody($message);

        foreach ($to as $recipient) {
            $this->message->addTo($recipient);
        }
    }

    /**
     * @throws \Nette\Mail\SendException
     */
    public function notify(Array $messageParams = []) {
        // parametrize message if needed
        if (!empty($messageParams)) {
            $message = sprintf($this->message->getBody(), ...$messageParams);
            $this->message->setBody($message);
        }
        $this->mailer->send($this->message);
    }

}
