<?php
    namespace App\Notifications;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class ApprovedTeam extends Notification
    {
        use Queueable;
        protected $researchTopicId;
        protected $subjectId;

        public function __construct($researchTopicId, $subjectId)
        {
            $this->researchTopicId = $researchTopicId;
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
                'researchTopicId' => $this->researchTopicId,
                'subjectId' => $this->subjectId,
                'title' => 'Equipo Aprobado',
                'type' => 'AT',
            ];
        }
    }
?>