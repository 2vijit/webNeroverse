<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovePayment extends Mailable
{
    use Queueable, SerializesModels;   
    public $paymentDetails;  
    public $reservationId;  
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentDetails,$reservationId)
    {        
        $this->paymentDetails = $paymentDetails;  
        $this->reservationId = $reservationId;  
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('reservation.payment_approval_mail')
                    ->subject('Payment Receipt');                
        // Check if paymentDetails is not null before attaching
        if ($this->paymentDetails) {
            $mail->attach($this->paymentDetails->getRealPath(),
            [
                'as' => $this->paymentDetails->getClientOriginalName(),
                'mime' => $this->paymentDetails->getClientMimeType(),
            ]);
        }
        return $mail;
    }
}
