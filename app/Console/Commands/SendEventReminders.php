<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotificaton;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'description here';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
        ->whereBetween('start_time',[now(),now()->addDay()])
        ->get();
        $eventsCount = $events->count();
        $eventLabel = Str::plural('event',$events);
        $this->info("We have {$eventsCount} {$eventLabel}");

        $events->each(function($event){
            $event->attendees->each(function($attendee)use($event){
                $attendee->user->notify(new EventReminderNotificaton($event));
            });
        });



        $this->info('reminder here');
    }
}
