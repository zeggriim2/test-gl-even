<?php

declare(strict_types=1);

namespace App\Tests;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class CsvTest extends WebTestCase
{
    #[NoReturn] public function testCsvSuccess(): void
    {

        $client = static::createClient([],  [
            'PHP_AUTH_USER' => 'toto',
            'PHP_AUTH_PW'   => '789',
        ]);


        $crawler = $client->request(Request::METHOD_GET, '/admin');

        $this->assertResponseIsSuccessful();

        $uploadedFile = new UploadedFile(
            __DIR__ . '/data/data1.csv',
            "data1.csv"
        );

        $form = $crawler->filter("form")->form([
            "admin[file]" => $uploadedFile
        ]);

        $client->submit($form);

        /** @var InMemoryTransport $transport */
        $transport = self::getContainer()->get('messenger.transport.async');
        $this->assertCount(1, $transport->getSent());

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}