<?php

declare(strict_types=1);
namespace App\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;


class BasicAuth
{
    protected ?string $directoryPath = null;
    protected ?string $htpasswdPath = null;
    protected Collection $userData;

    #[Pure] public function __construct()
    {
        $this->userData = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getDirectoryPath(): ?string
    {
        return $this->directoryPath;
    }

    /**
     * @param string|null $directoryPath
     * @return BasicAuth
     */
    public function setDirectoryPath(?string $directoryPath): self
    {
        $this->directoryPath = $directoryPath;
        return $this;
    }

    /**
     * @return string|null
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
     * @return Collection
     */
    public function getUserData(): Collection
    {
        return $this->userData;
    }

    public function setUserData(Collection $userData): self
    {
        $this->userData = $userData;
        return $this;
    }

    /**
     * @param UserData $data
     * @return $this
     */
    public function addUserData(UserData $data): self
    {
        $data->setBasicAuths($this);
        $this->userData->add($data);
        return $this;
    }

    /**
     * @param UserData $data
     */
    public function removeUserData(UserData $data)
    {
        $this->userData->removeElement($data);
    }
}