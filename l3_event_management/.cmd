php artisan make:model Event -m
php artisan make:model Attendee -m
php artisan make:controller Api/AttendeeController --api // --api flag: It will remove those function (create, edit) which are responsible for showing the form
php artisan make:controller Api/EventController --api
php artisan route:list // run in terminal after api route setting
php artisan make:factory EventFactory --model=Event
php artisan make:seeder EventSeeder
php artisan make:seeder AttendeeSeeder
// this should be run after seeder and factory command run
php artisan migrate:refresh --seed
php artisan make:resource EventResource
D:\Laravel\Coursera\l3_event_management\app\Http\Traits (Create Traits)
Gate use in AuthServiceProvider
php artisan make:policy EventPolicy --model=Event
php artisan make:policy AttendeePolicy --model=Attendee

// this store in app\Console\Commands\SendEventReminders
php artisan make:command SendEventReminders // show this command to run "php artisan"
php artisan app:send-event-reminders

// Task (Event) schedule in app\Console\Kernel.php
php artisan schedule:work // It should run in separate tab and if make any changes then it should run this command again

// Notification
php artisan make:notification EventReminderNotification
php artisan app:send-event-reminders // run the notification which store in SendEventReminders

// Queue
php artisan queue:table
php artisan migrate
php artisan queue:work // this command should run always