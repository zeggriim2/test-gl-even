<?php

namespace App\MessageHandler;

use App\Message\CsvMessage;
use App\Services\Model\LineCsvExit;
use App\Services\SendEmail\Mailer;
use App\Services\Transform\TransformLineLineEntreToLineExit;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CsvMessageHandler implements MessageHandlerInterface
{
    /** @var LineCsvExit[] */
    private array $linesExit = [];


    public function __construct(
        private readonly TransformLineLineEntreToLineExit $transformeLine,
        private readonly Mailer                           $mailer,
        private readonly string                           $dataDirectory
    )
    {
    }

    public function __invoke(CsvMessage $message)
    {
        $this->linesExit = $this->transformeLine->transform($message->geLinesEnter());

        // On créé le fichier
        $filePath = $this->fileCsv();

        $this->mailer->envoyer($filePath);
    }

    private function fileCsv(): string
    {
        $filePath = $this->dataDirectory . 'fileEmail.csv';
        $f = fopen($filePath, 'w');

        foreach ($this->linesExit as $line){
            fputcsv($f,[$line->getCivite(), $line->getEmail()]);
        }
        fclose($f);

        return $filePath;
    }
}
