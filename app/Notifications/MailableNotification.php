<?php

namespace App\Notifications;

use App\Exceptions\CustomException;
use App\Zen\User\Model\User;
use Hyn\Tenancy\Models\Hostname;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MailableNotification extends Notification
{
    use Queueable;
    protected $websiteId;
    /**
     * @var
     */
    private $allDeals;
    /**
     * @var
     */
    private $user;


    /**
     * Create a new notification instance.
     * @param array $allDeals
     * @param User $user
     * @param $websiteId
     */
    public function __construct(array $allDeals, User $user, int $websiteId)
    {
        $this -> allDeals = $allDeals;
        $this -> user = $user;
        $this -> websiteId = $websiteId;
    }

    /**
     * Get the notification's delivery channels.
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this -> getRelativeUrl();
        return (new MailMessage) -> subject('Maturing Leases')
            -> markdown('emails.notification.maturing', ['deals' => $this -> allDeals, 'user' => $this -> user, 'url' => $url]);
    }

    /**
     * Get the array representation of the notification.
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * @return string
     * @throws CustomException
     */
    private function getRelativeUrl(): string
    {
        /* put app url and server url in environment variable so that the hostname comes as correct in maturing email*/
        if(!env('SERVER_URL') || !env('APP_URL'))
            throw new CustomException('Please setup environment value, contact administrator');

        $hostName = Hostname ::where('website_id', $this -> websiteId) -> first();
        $url = str_replace(env('SERVER_URL'), $hostName -> fqdn, env('APP_URL'));
        return $url;
    }
}
