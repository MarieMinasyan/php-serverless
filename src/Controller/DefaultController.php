<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{
    public function index()
    {
        $jobs = [
            'Fireman',
            'Astronaut',
            'Super hero',
            'Pilot',
            'Professional cook',
            'Artist',
        ];

        return new JsonResponse([
            'occupation' => $jobs[array_rand($jobs)],
        ]);
    }
}
