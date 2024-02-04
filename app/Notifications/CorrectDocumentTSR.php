<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class CorrectDocumentTSR extends Notification
    {
        use Queueable;
        protected $correctDocumentTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $correctDocumentTSR, $idcId)
        {
            $this->correctDocumentTSR = $correctDocumentTSR;
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
                'idTopicSearchReport' => $this->correctDocumentTSR->topicSearchReportId,
                'title' => 'Se debe corregir el Informe de Búsqueda de Información',
                'type' => 'TSRCRD',
            ];
        }
    }
?>