<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class DeclineTSR extends Notification
    {
        use Queueable;
        protected $declineTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $declineTSR, $idcId)
        {
            $this->declineTSR = $declineTSR;
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
                'idTopicSearchReport' => $this->declineTSR->topicSearchReportId,
                'title' => 'Informe de Búsqueda de Información Rechazado',
                'type' => 'TSRDEC',
            ];
        }
    }
?>