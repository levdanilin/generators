<?php

namespace App\DTO;

class UserData
{
    private ?string $userName = null;
    private ?string $password = null;
    private BasicAuth $basicAuths;

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return UserData
     */
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;
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
     * @param string $password
     * @return UserData
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return BasicAuth
     */
    public function getBasicAuth(): BasicAuth
    {
        return $this->basicAuths;
    }

    /**
     * @param BasicAuth $basicAuths
     * @return UserData
     */
    public function setBasicAuths(BasicAuth $basicAuths): self
    {
        $this->basicAuths = $basicAuths;
        return $this;
    }
}