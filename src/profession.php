<?php

function occupation()
{
    $jobs = [
        'Fireman',
        'Astronaut',
        'Super hero',
        'Pilot',
        'Professional cook',
        'Artist',
    ];

    return ['occupation' => $jobs[array_rand($jobs)]];
}
