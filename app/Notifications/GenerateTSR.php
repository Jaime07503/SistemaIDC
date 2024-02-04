<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class GenerateTSR extends Notification
    {
        use Queueable;
        protected $generateTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $generateTSR, $idcId)
        {
            $this->generateTSR = $generateTSR;
            $this->idcId = $idcId;
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

        public function toDatabase($notifiable)
        {
            return [
                'idcId' => $this->idcId,
                'idTopicSearchReport' => $this->generateTSR->topicSearchReportId,
                'title' => 'Informe de Búsqueda de Información Generado',
                'type' => 'TSR',
            ];
        }
    }
?>