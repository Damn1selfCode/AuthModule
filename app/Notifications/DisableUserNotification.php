<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class DisableUserNotification extends Notification
{
    use Queueable;

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user; // Asignar el usuario a la propiedad
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
{
    $confirmationUrl = url('/confirm-disable/' . $this->user->id);

    return (new MailMessage)
        ->line('Estás a punto de ser deshabilitado en nuestra plataforma.')
        ->action('Confirmar Deshabilitación', $confirmationUrl)
        ->line('Si no has solicitado esta deshabilitación, por favor ignora este mensaje.');
}


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
