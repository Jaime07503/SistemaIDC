<?php
    namespace App\Notifications;
    use App\Models\TopicSearchReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class ChangeCorrectDocumentTSR extends Notification
    {
        use Queueable;
        protected $changeCorrectTSR;
        protected $idcId;

        public function __construct(TopicSearchReport $changeCorrectTSR, $idcId)
        {
            $this->changeCorrectTSR = $changeCorrectTSR;
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
                'idTopicSearchReport' => $this->changeCorrectTSR->topicSearchReportId,
                'title' => 'Se cambio Informe de Temas próxima IDC con Correcciones',
                'type' => 'CHTSRCRT',
            ];
        }
    }
?>