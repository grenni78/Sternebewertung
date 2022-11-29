<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class WebPushNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string $type    Type of the Notification
     * @param string $title   Title of the Notification
     * @param string $message Text associated to the Notification
     * @param        $data Content of the Notification
     * @param string $action_title Title of the assigned action
     * @param string $action_url   Action URL of the assigned action
     * @return void
     */
    public function __construct(string $type, ?string $title = null, ?string $message = null, $data = null, ?string $action_title = null, ?string $action_url = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->action_title = $action_title;
        $this->action_url = $action_url;
        $this->data = json_encode($data);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class, 'database'];
    }

    /**
     * Get the WebPush representation of the notification
     */
    public function toWebPush($notifiable, $notification)
    {
        $notification = new WebPushMessage;
        if ($this->title) {
            $notification->title(config('app.name', 'Laravel') . ' - ' . $this->title);
        }

        $notification->icon('/notification-icon.png');

        if ($this->message) {
            $notification->body($this->message);
        }

        $data = \json_decode($this->data, true);
        $data["type"] = $this->type;
        $notification->data($data);

        if ($this->action_title && $this->action_url) {
            $notification->action($this->action_title, $this->action_url);
        }

        return $notification;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
