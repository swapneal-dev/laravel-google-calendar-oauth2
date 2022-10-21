<?php

namespace Spatie\GoogleCalendar;

use Illuminate\Support\ServiceProvider;
use Spatie\GoogleCalendar\Exceptions\InvalidConfiguration;

class GoogleCalendarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/google-calendar.php' => config_path('google-calendar.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/google-calendar.php', 'google-calendar');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->bind(GoogleCalendar::class, function () {
            $config = config('google-calendar');

            $this->guardAgainstInvalidConfiguration($config);

            return GoogleCalendarFactory::createForCalendarId(auth()->user()->google_calender_id);
        });

        $this->app->alias(GoogleCalendar::class, 'laravel-google-calendar');
    }

    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        if (!auth()->check()) {
            throw InvalidConfiguration::authenticationRequired();
        }

        if (empty(auth()->user()->google_calender_id)) {
            throw InvalidConfiguration::calendarIdNotSpecified();
        }

        $authProfile = $config['default_auth_profile'];

        if ($authProfile === 'service_account') {
            $this->validateServiceAccountConfigSettings($config);

            return;
        }

        if ($authProfile === 'oauth') {
            $this->validateOAuthConfigSettings($config);

            return;
        }

        throw InvalidConfiguration::invalidAuthenticationProfile($authProfile);
    }

    protected function validateServiceAccountConfigSettings(array $config = null)
    {
        $credentials = $config['auth_profiles']['service_account']['credentials_json'];

        $this->validateConfigSetting($credentials);
    }

    protected function validateOAuthConfigSettings(array $config = null)
    {
        $credentials = $config['auth_profiles']['oauth']['credentials_json'];

        $this->validateConfigSetting($credentials);

        $this->validateConfigSetting(auth()->user()->getGoogleAccessToken());
    }

    protected function validateConfigSetting(string $setting)
    {
        if (! is_array($setting) && ! is_string($setting)) {
            throw InvalidConfiguration::credentialsTypeWrong($setting);
        }

        if (is_string($setting) && ! file_exists($setting)) {
            throw InvalidConfiguration::credentialsJsonDoesNotExist($setting);
        }
    }
}
