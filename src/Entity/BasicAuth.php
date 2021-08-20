<?php

declare(strict_types=1);
namespace App\Entity;

class BasicAuth
{
    private string $securityArea;
    private string $htpasswdPath;
    private string $userName;
    private string $password;

    /**
     * @return string
     */
    public function getSecurityArea(): string
    {
        return $this->securityArea;
    }

    /**
     * @param string $securityArea
     * @return BasicAuth
     */
    public function setSecurityArea(string $securityArea): self
    {
        $this->securityArea = $securityArea;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtpasswdPath(): string
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
    public function getUserName(): string
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
    public function getPassword(): string
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