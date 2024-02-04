<?php
    namespace App\Notifications;
    use App\Models\NextIdcTopicReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class CorrectedDocumentNTR extends Notification
    {
        use Queueable;
        protected $correctedNTR;
        protected $idcId;

        public function __construct(NextIdcTopicReport $correctedNTR, $idcId)
        {
            $this->correctedNTR = $correctedNTR;
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
                'idNextIdcTopicReport' => $this->correctedNTR->nextIdcTopicReportId,
                'title' => 'Informe de Temas próxima IDC con correcciones subido',
                'type' => 'NTRCRT',
            ];
        }
    }
?>