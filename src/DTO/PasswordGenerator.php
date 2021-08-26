<?php

namespace App\DTO;

class PasswordGenerator
{
    private int $length;
    private ?bool $upperCase = null;
    private ?bool $lowerCase = null;
    private ?bool $numbers = null;
    private ?bool $symbols = null;
    private ?string $password = null;


    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return PasswordGenerator
     */
    public function setLength(int $length): self
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasUpperCase(): ?bool
    {
        return $this->upperCase;
    }

    /**
     * @param bool|null $upperCase
     * @return PasswordGenerator
     */
    public function setUpperCase(?bool $upperCase): self
    {
        $this->upperCase = $upperCase;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasLowerCase(): ?bool
    {
        return $this->lowerCase;
    }

    /**
     * @param bool|null $lowerCase
     * @return PasswordGenerator
     */
    public function setLowerCase(?bool $lowerCase): self
    {
        $this->lowerCase = $lowerCase;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasNumbers(): ?bool
    {
        return $this->numbers;
    }

    /**
     * @param bool|null $numbers
     * @return PasswordGenerator
     */
    public function setNumbers(?bool $numbers): self
    {
        $this->numbers = $numbers;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function hasSymbols(): ?bool
    {
        return $this->symbols;
    }

    /**
     * @param bool|null $symbols
     * @return PasswordGenerator
     */
    public function setSymbols(?bool $symbols): self
    {
        $this->symbols = $symbols;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return PasswordGenerator
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

}