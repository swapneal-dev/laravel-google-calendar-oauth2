
# Manage events on a Google Calendar with oauth support

This package is forked from [spatie's calendar package](https://github.com/spatie/laravel-google-calendar) with extended oauth support.

# Installation

Install using composer<br>
```bash
composer require swapneal-dev/laravel-google-calendar-oauth2
```

You must publish the configuration with this command:

```
php artisan vendor:publish --provider="Spatie\GoogleCalendar\GoogleCalendarServiceProvider"
```

1. Setup oauth config in `google-calendar.php`
2. Run migration
3. add your access key to `google_access_token` column in users table.
4. add calendar id to `google_calender_id` column in users table.
5. add trait to user model `Spatie\GoogleCalendar\traits\HasGoogleToken`

# I have created an example project for google calender implementation of this package.
https://github.com/swapneal-dev/google-calender-and-contacts

Now you are good to go.
