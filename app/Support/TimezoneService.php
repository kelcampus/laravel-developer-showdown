<?php

namespace App\Support;

use DateTime;
use DateTimeZone;

class TimezoneService
{
    public function getRandomTimeZone(): string
    {
        $timezones = $this->getTimeZones();
        return $timezones[array_rand($timezones)];
    }

    public function getTimeZones(): array
    {
        return array_merge(
            $this->getTimeZonesByUTCOffset(1), // UTC+1 <==> GMT+1
            $this->getTimeZonesByUTCOffset(-6) // UTC-6
        );
    }

    private function getTimeZonesByUTCOffset($offset): array
    {
        $matchingTimeZones = [];

        $timeZones = DateTimeZone::listIdentifiers();

        foreach ($timeZones as $timeZone) {
            $dateTimeZone = new DateTimeZone($timeZone);

            // Get the UTC offset for the time zone
            $utcOffset = $dateTimeZone->getOffset(new DateTime("now"));

            // Convert the offset to hours
            $offsetHours = $utcOffset / 3600;

            // Check if the offset matches the provided offset
            if ($offsetHours === $offset) {
                $matchingTimeZones[] = $timeZone;
            }
        }

        return $matchingTimeZones;
    }
}


