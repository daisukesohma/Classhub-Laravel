<?php

namespace App\Console;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\FreeVideoCallController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\RefundRequestController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\RefundRequest;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        
        // Class reminder
        $schedule->call(function () {
            BookingController::classReminder();
        })->hourlyAt(5);
        
        // Setup class reminder
        /*$schedule->call(function () {
            EducatorController::setupClassReminder();
        })->hourlyAt(20);*/
        
        // Payout cron
        $schedule->call(function () {
            StripeController::requestPayout();
        })->hourlyAt(35);
        
        // Refund request
        $schedule->call(function () {
            RefundRequestController::processRefundRequests();
        })->twiceDaily();
        
        // Weekly Stats
        // $schedule->call(function () {
        //     EducatorController::weeklyStats();
        // })->weekly()->sundays()->at('23:00');
        
        // Move to expired
        $schedule->call(function () {
            LessonController::moveToExpired();
        })->everyFiveMinutes();
        
        // Draft lesson reminder
        $schedule->call(function () {
            EducatorController::draftLessonsReminder();
        })->dailyAt('9:00');
        
        // Video Call reminder
        $schedule->call(function () {
            UserController::videoCallReminder();
        })->everyFiveMinutes();

        // Free Video Call reminder
        $schedule->call(function () {
            UserController::freeVideoCallReminder();
        })->everyMinute();
        
        // Trusted reminder
        $schedule->call(function () {
            EducatorController::trustedReminder();
        })->dailyAt('10:00');
        
        // Jobs Board reminder
        /*$schedule->call(function () {
            EducatorController::jobsBoardReminder();
        })->dailyAt('12:00');*/
        
        $schedule->call(function () {
            EducatorController::deleteOldTutorRequests();
        })->dailyAt('12:00');

        // Delete old chat files
        $schedule->call(function () {
            MessageController::deleteOldChatFiles();
        })->dailyAt('13:00');
        
        $schedule->call(function () {
            EducatorController::deactivateTutorAccounts();
        })->dailyAt('15:00');
        
        $schedule->call(function () {
            LessonController::checkVideoTranscodingStatus();
        })->everyThirtyMinutes();

        $schedule->call(function () {
            LessonController::deleteOldZoomMeetings();
        })->everyFiveMinutes();

        $schedule->call(function () {
            FreeVideoCallController::deleteOldZoomMeetings();
        })->everyFiveMinutes();

        $schedule->call(function () {
            FreeVideoCallController::zoomMeetingCompleted();
        })->everyMinute();
        
        // Set Top performers
        $schedule->call(function () {
            EducatorController::setTopPerformers();
        })->hourly();
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        
        require base_path('routes/console.php');
    }
}
