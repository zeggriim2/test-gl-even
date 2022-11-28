<?php

namespace App\Message;

use App\Services\Model\LineCsvEnter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CsvMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     private array $linesEnter;

     public function __construct(array $linesEnter)
     {
         $this->linesEnter = $linesEnter;
     }

    public function geLinesEnter(): array
    {
        return $this->linesEnter;
    }
}
