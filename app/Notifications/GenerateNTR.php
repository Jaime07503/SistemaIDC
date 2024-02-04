<?php
    namespace App\Notifications;
    use App\Models\NextIdcTopicReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class GenerateNTR extends Notification
    {
        use Queueable;
        protected $generateNTR;
        protected $idcId;

        public function __construct(NextIdcTopicReport $generateNTR, $idcId)
        {
            $this->generateNTR = $generateNTR;
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
                'idNextIdcTopicReport' => $this->generateNTR->nextIdcTopicReportId,
                'title' => 'Informe de Temas próxima IDC Generado',
                'type' => 'NTR',
            ];
        }
    }
?>