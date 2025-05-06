<?php

return [

    /* Name of the key to increment in Redis. */
    'key' => 'job_processed_count',

    /* Amount of jobs to be processed before restarting Laravel Horizon. */
    'threshold' => env('HORIZON_RESTARTER_THRESHOLD', 100000),

];
