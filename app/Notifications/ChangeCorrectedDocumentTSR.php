<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class changeCorrectedDocumentTSR extends Notification
    {
        use Queueable;
        protected $changeCorrectedTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $changeCorrectedTSR, $idcId)
        {
            $this->changeCorrectedTSR = $changeCorrectedTSR;
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
                'idTopicSearchReport' => $this->changeCorrectedTSR->topicSearchReportId,
                'title' => 'Se cambio el Informe de Temas próxima IDC Corregido',
                'type' => 'CHNTRCRD',
            ];
        }
    }
?>