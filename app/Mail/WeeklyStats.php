<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class WeeklyStats extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;
    
    public $educator;
    
    public $numSearches;
    
    public $profileViews;
    
    public $lessonViews;
    
    public $numLikes;
    
    public $rating;
    
    public $numBookings;
    
    public $avgBookingAmount;
    
    public $avgEarningAmount;
    
    public $avgCommissionAmount;
    
    public $unsubscribeEmail;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($educator, $stats, $unsubscribeEmail)
    {
        $this->educator = $educator;
        
        $this->numSearches = $stats['num_searches'];
        
        $this->profileViews = $stats['profile_views'];
        
        $this->lessonViews = $stats['lesson_views'];
        
        $this->numLikes = $stats['num_likes'];
        
        $this->rating = $stats['rating'];
        
        $this->numBookings = $stats['num_bookings'];
        
        $this->avgBookingAmount = $stats['avg_booking_amount'];
        
        $this->avgEarningAmount = $stats['avg_earning_amount'];
        
        $this->avgCommissionAmount = $stats['avg_commission_amount'];
        
        $this->unsubscribeEmail = $unsubscribeEmail;
        
        \Log::info('Weekly stats email: ' . $this->unsubscribeEmail);
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Weekly stats from Classhub')
            ->view('system-emails.weekly-stats')->sendgrid(['personalizations' => [],]);
    }
}
