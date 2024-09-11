composer require livewire/livewire

@REM In below way the migration will not work because for the foreign key.
@REM When the vote table will migrate then it will try to find the votes table foreign key but at that time the votes table is not created that's why the error will shown.
@REM So I need to twick like make Option model before the Vote model or rename the Option model which will serialized before the Vote model.
php artisan make:model Poll -m
php artisan make:model Vote -m
php artisan make:model Option -m

php artisan make:livewire CreatePoll
php artisan make:livewire Polls