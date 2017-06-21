<?php

if (!function_exists('date_range')) {
    function date_range(Carbon\Carbon $from, Carbon\Carbon $to)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy();
        $to = $to->copy();

        $step = Carbon\CarbonInterval::hour();
        $period = new DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $hour) {
            $range[] = new Carbon\Carbon($hour);
        }

        return ! empty($range) ? $range : null;
    }
}
