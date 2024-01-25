<?php
    namespace App\Notifications;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class Notificacion extends Notification
    {
        use Queueable;
        protected $researchTopic;

        public function __construct($researchTopic)
        {
            $this->researchTopic = $researchTopic;
        }

        public function via($notifiable)
        {
            return ['database'];
        }

        public function toDatabase($notifiable)
        {
            return [
                'title' => $this->researchTopic->title,
                'message' => 'Nueva notificación.',
                'link' => route('researchTopicInformation', [
                    'researchTopicId' => $this->researchTopic->researchTopicId,
                    'subjectId' => $this->researchTopic->subjectId,
                ]),
            ];
        }
    }

    class DatabaseChannel
    {
        public function send($notifiable, Notificacion $notification) {
            $data = $notification->toDatabase($notifiable);

            $notifiable->notification()->create($data);
        }
    }
?>