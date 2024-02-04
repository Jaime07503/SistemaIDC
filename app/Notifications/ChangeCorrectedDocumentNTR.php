<?php
    namespace App\Notifications;
    use App\Models\NextIdcTopicReport;
    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class changeCorrectedDocumentNTR extends Notification
    {
        use Queueable;
        protected $changeCorrectedNTR;
        protected $idcId;

        public function __construct(NextIdcTopicReport $changeCorrectedNTR, $idcId)
        {
            $this->changeCorrectedNTR = $changeCorrectedNTR;
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
                'idNextIdcTopicReport' => $this->changeCorrectedNTR->nextIdcTopicReportId,
                'title' => 'Se cambio el Informe de Temas próxima IDC Corregido',
                'type' => 'CHNTRCRD',
            ];
        }
    }
?>