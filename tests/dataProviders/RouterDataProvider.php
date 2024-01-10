<?php

declare(strict_types=1);

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function routeNotFoundCasesDataProvider(): array 
    {
        return [
            ['/users', 'put'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }

    public function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }
}