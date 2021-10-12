<?php

namespace App\Notifications;

use function __;
use App\Models\Admin\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use function route;

class DataTablesExportDone extends Notification
{
    use Queueable;
    /**
     * @var \App\Models\Admin\Report
     */
    public $report;

    /**
     * DataTablesExportDone constructor.
     * @param \App\Models\Admin\Report $report
     */
    public function __construct(Report $report)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $state = '';
        switch ($this->report->state){
            case 'in_progress':
                $state = __('In progress');
                break;
            case 'completed':
                $state =  __('Completed');
                break;
            case 'failed':
                $state = __('Failed');
                break;
        }

        return (new MailMessage)
            ->from(config('main.emails.no_replay'))
            ->subject(__('Requested report'))
            ->view('emails.admin.dt-export-done', ['notifiable' => $notifiable, 'report' => $this->report, 'state' => $state]);
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
            //
        ];
    }
}
