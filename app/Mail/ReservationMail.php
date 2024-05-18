<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $user;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $emailData, $pdfPath)
    {
        $this->reservation = $emailData['reservation'];
        $this->user = $emailData['user'];
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reservation Confirmation')
                    ->view('reservation.reservation_mail')
                    ->attach($this->pdfPath, [
                        'as' => $this->reservation->reservation_id . '_invoice.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
