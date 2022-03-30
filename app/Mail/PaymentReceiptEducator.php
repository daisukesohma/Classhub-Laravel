<?php

namespace App\Mail;

use App\Helpers\ClassHubHelper;
use App\Lesson;
use App\LessonClass;
use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class PaymentReceiptEducator extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $booking;
    
    public $class;
    
    public $educator;
    
    public $parent;
    
    public $lesson;
    
    public $payoutAmount;
    
    public $singleClassAmount;
    
    public $serviceCharge;
    
    public $transactionId;
    
    public $unsubscribeEmail;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $class, $payoutAmount, $unsubscribeEmail)
    {
        $this->booking = $booking;
        
        $transaction = Transaction::where('booking_id', $this->booking->id)
            ->where('type', 'charge')->first();
        
        $this->transactionId = $transaction->txn_id;
        
        $this->class = $class;
        
        $this->lesson = Lesson::withTrashed()->findOrFail($booking->lesson_id);
        
        $this->educator = User::withTrashed()->findOrFail($this->lesson->user_id);
        
        $this->parent = $booking->user;
        
        $this->payoutAmount = $payoutAmount;
        
        $this->singleClassAmount = ClassHubHelper::roundCents(($booking->amount - $booking->service_fee)
            / $booking->classes->count());
        
        $this->serviceCharge = $this->singleClassAmount - $this->payoutAmount;
        
        $this->unsubscribeEmail = $unsubscribeEmail;
        
        \Log::info('Payout email: ' . $this->unsubscribeEmail . ', Class ID : ' . $this->class->id);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Classhub Payout is on the way')
            ->view('system-emails.payment-receipt-educator')->sendgrid(['personalizations' => [],]);
    }
}
