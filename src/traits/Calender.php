<?php

namespace Spatie\GoogleCalendar\traits;

trait Calender
{
    protected function getArrayableItems(array $values)
    {
        if(!in_array('google_access_token', $this->hidden)){
            $this->hidden[] = 'google_access_token';
        }
        return parent::getArrayableItems($values);
    }

    public function getGoogleAccessToken(){
        $this->makeVisible('google_access_token');
        return $this->google_access_token;
    }
}
