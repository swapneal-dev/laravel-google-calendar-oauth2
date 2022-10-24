
# Manage events on a Google Calendar with oauth support

This package is forked from [spatie's calendar package](https://github.com/spatie/laravel-google-calendar) with extended oauth support.

1. Setup oauth config in `laravel-calendar.php`
2. Run migration
3. add your access key to `google_access_token` column in users table.
4. add calendar id to `google_calender_id` column in users table.
5. add trait to user model `Spatie\GoogleCalendar\traits\Calender`

Now you are good to go.
