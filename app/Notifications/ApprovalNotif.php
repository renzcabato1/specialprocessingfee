<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovalNotif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $form;
    public function __construct($form)
    {
        //
        $this->form = $form;
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
        // dd($this->form);
        $user = User::where('id', $this->form->encode_by)->first();
        // dd($this->form);
        return (new MailMessage)

            ->subject('Approvals')
            ->greeting('Good Day!')
            ->greeting('Request for Approval!')
            ->line(new HtmlString('Requested Date: <strong>' . date('F d, Y') . '</strong>'))
            ->line('SPF Control #: SPF-' . str_pad($this->form->id, 6, '0', STR_PAD_LEFT))
            ->line('Amount: ' . number_format($this->form->amount,   2))
            ->line('Request by: ' . $user->name)
            ->action('View Request', url('for-verification'))
            ->line('Thank you for using our application!');
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
