<?php
    namespace App\Notifications;
    use App\Models\ScientificArticleReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class GenerateSAR extends Notification
    {
        use Queueable;
        protected $generateSAR;
        protected $idcId;

        public function __construct(ScientificArticleReport $generateSAR, $idcId)
        {
            $this->generateSAR = $generateSAR;
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
                'idScientificArticleReport' => $this->generateSAR->scientificArticleReportId,
                'title' => 'Informe de Artículo Científico Generado',
                'type' => 'SAR',
            ];
        }
    }
?>