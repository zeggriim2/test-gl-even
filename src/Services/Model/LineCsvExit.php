<?php

declare(strict_types=1);

namespace App\Services\Model;

final class LineCsvExit
{
    private string $civite;
    private string $email;

    /**
     * @return string
     */
    public function getCivite(): string
    {
        return $this->civite;
    }

    /**
     * @param string $civite
     * @return LineCsvExit
     */
    public function setCivite(string $civite): LineCsvExit
    {
        $this->civite = $civite;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LineCsvExit
     */
    public function setEmail(string $email): LineCsvExit
    {
        $this->email = $email;
        return $this;
    }
}