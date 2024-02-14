<?php
    namespace App\Notifications;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class PostulateResearchTopic extends Notification
    {
        use Queueable;
        protected $subjectId;

        public function __construct($subjectId)
        {
            $this->subjectId = $subjectId;
        }

        public function via($notifiable)
        {
            return ['database'];
        }

        public function toMail($notifiable)
        {
            return (new MailMessage)
                        ->line('The introduction to the notification.')
                        ->action('Notification Action', url('/'))
                        ->line('Thank you for using our application!');
        }

        public function toArray($notifiable)
        {
            return [
                'subjectId' => $this->subjectId,
                'title' => 'Tema de Investigación Aprobado',
                'type' => 'PRT',
            ];
        }
    }
?>