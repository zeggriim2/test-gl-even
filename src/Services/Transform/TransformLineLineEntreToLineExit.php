<?php

declare(strict_types=1);

namespace App\Services\Transform;

use App\Services\Model\LineCsvEnter;
use App\Services\Model\LineCsvExit;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TransformLineLineEntreToLineExit implements TransformLine
{
    private array $linesEnter;
    private array $linesExit = [];

    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    public function transform(array $linesEnter): array
    {
        $this->linesEnter = $linesEnter;
        $errors = $this->checkError();

        if ($errors->count() > 0) {
            $this->removeLine($errors);
        }

        $this->transEnterToExit();

        return $this->linesExit;
    }

    private function checkError(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this->linesEnter);
    }

    private function removeLine(ConstraintViolationListInterface $errors)
    {
        /** @var ConstraintViolation $error */
        $clean = ['[', ']'];
        foreach ($errors as $error) {
            $pos = strpos($error->getPropertyPath(), '.');
            $pos = substr($error->getPropertyPath(), 0, $pos);
            unset($this->linesEnter[str_replace($clean, '', $pos)]);
        }
    }


    private function transEnterToExit()
    {
        /** @var LineCsvEnter[] $linesEnter */
        foreach ($this->linesEnter as $line) {
            $this->linesExit[] = (new LineCsvExit())
                ->setCivite($line->getFullName())
                ->setEmail($line->getEmail());
        }
    }

}