<?php

namespace App\Mail;

use App\BookingClass;
use App\Image;
use App\Lesson;
use App\LessonClass;
use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class BookingParent extends Mailable
{
    use Queueable, SerializesModels;
    
    use SendGrid;

    public $booking;

    public $classes;

    public $transaction;

    public $educator;

    public $lesson;

    public $photoUrl;

    public $lessonImageUrl;
    
    public $unsubscribeEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $unsubscribeEmail)
    {
        $this->booking = $booking;

        $this->classes = LessonClass::whereIn('id', $booking->classes->pluck('lesson_class_id')->toArray())->get();

        $this->transaction = json_decode(Transaction::whereBookingId($booking->id)->first()->txn_details);

        $this->lesson = Lesson::findOrFail($booking->lesson_id);

        $this->educator = User::findOrFail($this->lesson->user_id);

        $this->photoUrl = Storage::url(Image::findOrFail($this->educator->educator->photo)->path);

        $this->lessonImageUrl = $this->lesson->images->count() ? Storage::url($this->lesson->images->first()->path) : '';
    
        $this->unsubscribeEmail = $unsubscribeEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your receipt from Classhub')
            ->view('system-emails.booking-parent')->sendgrid(['personalizations' => [],]);
    }
}


