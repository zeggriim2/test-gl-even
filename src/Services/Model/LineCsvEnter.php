<?php

declare(strict_types=1);

namespace App\Services\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class LineCsvEnter
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;
    private string $nom;
    private string $prenom;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LineCsvEnter
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return LineCsvEnter
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return LineCsvEnter
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->prenom . " " . strtoupper($this->nom);
    }
}