<?php
    namespace App\Notifications;
    use App\Models\ScientificArticleReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class DeclineSAR extends Notification
    {
        use Queueable;
        protected $declineSAR;
        protected $idcId;

        public function __construct(ScientificArticleReport $declineSAR, $idcId)
        {
            $this->declineSAR = $declineSAR;
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
                'idScientificArticleReport' => $this->declineSAR->scientificArticleReportId,
                'title' => 'Informe de Artículo Científico Rechazado',
                'type' => 'SARDEC',
            ];
        }
    }
?>