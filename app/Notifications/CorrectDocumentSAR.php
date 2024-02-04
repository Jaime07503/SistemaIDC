<?php
    namespace App\Notifications;
    use App\Models\ScientificArticleReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class CorrectDocumentSAR extends Notification
    {
        use Queueable;
        protected $correctSAR;
        protected $idcId;

        public function __construct(ScientificArticleReport $correctSAR, $idcId)
        {
            $this->correctSAR = $correctSAR;
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
                'idScientificArticleReport' => $this->correctSAR->scientificArticleReportId,
                'title' => 'Se debe corregir el Informe de Artículo Científico',
                'type' => 'SARCRD',
            ];
        }
    }
?>