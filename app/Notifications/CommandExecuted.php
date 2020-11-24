<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class CommandExecuted extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $task;

    /**
     * Create a new notification instance.
     * @param $task
     */
    public function __construct($task)
    {
        $this -> task = $task;
    }

    /**
     * Get the notification's delivery channels.
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $task = $this -> task;
        return (new SlackMessage)
            -> success()
            -> content($task -> description . ' - on ' . php_uname("n").' server.');
    }
}
