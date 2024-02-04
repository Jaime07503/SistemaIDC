<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class ApproveTSR extends Notification
    {
        use Queueable;
        protected $approveTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $approveTSR, $idcId)
        {
            $this->approveTSR = $approveTSR;
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
                'idTopicSearchReport' => $this->approveTSR->topicSearchReportId,
                'title' => 'Informe de Búsqueda de Información Aprobado',
                'type' => 'TSRAPP',
            ];
        }
    }
?>