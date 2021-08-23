<?php

declare(strict_types=1);
namespace App\Entity;

class BasicAuth
{
    private ?string $directoryPath = null;
    private ?string $htpasswdPath = null;
    private ?string $userName = null;
    private ?string $password = null;

    /**
     * @return string|null
     */
    public function getDirectoryPath(): ?string
    {
        return $this->directoryPath;
    }

    /**
     * @param string|null $directionPath
     */
    public function setDirectoryPath(?string $directoryPath): self
    {
        $this->directoryPath = $directoryPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtpasswdPath(): ?string
    {
        return $this->htpasswdPath;
    }

    /**
     * @param string $htpasswdPath
     * @return BasicAuth
     */
    public function setHtpasswdPath(string $htpasswdPath): self
    {
        $this->htpasswdPath = $htpasswdPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return BasicAuth
     */
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return BasicAuth
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}