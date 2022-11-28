<?php

declare(strict_types=1);

namespace App\Tests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthTest extends WebTestCase
{
    /**
     * @dataProvider provideData
     * @return void
     */
    public function testAuth(string $username,string $code,int $codeStatus): void
    {

        $client = static::createClient();

        $client->request('GET', '/admin', [], [], [
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $code,
        ]);

        $this->assertResponseStatusCodeSame($codeStatus);
    }

    /**
     * @return Generator
     */
    public function provideData(): Generator
    {
        yield ['toto', '789', 200];
        yield ['toto', '7890', 401];
    }
}