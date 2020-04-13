<?php

return [
    'before_charge' => [
        'warn' => true,
        'before' => '2 days',
    ],

    'past_due' => [
        // 'interval' => '3 days',
        'reject' => '7 days',
    ],
];