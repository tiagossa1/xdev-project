<?php

namespace App\Notifications;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReport extends Notification
{
    use Queueable;

    public $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'reason'=>$this->report->reason,
            'user_id'=>$this->report->user_id,
            'post_id'=>$this->report->post_id
        ];
    }
}
