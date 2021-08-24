<?php

declare(strict_types=1);
namespace App\Entity;


use App\DTO\UserData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;



class BasicAuth
{
    protected ?string $directoryPath = null;
    protected ?string $htpasswdPath = null;
    protected Collection $userData;

    public function __construct()
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
     * @param string|null $htpasswdPath
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

    /**
     * TODO Es werden nur initial erstellte UserData-Objekte in Collection von BasicAuth-Object (Field UserData) gespeichert.
     * Die, die beim klicken auf Add User Button(in Template) erstellt werden, werden nicht in die Collection hinzüfigt und sind undefined.
     * Das liegt meine Vermutung nach entweder an dieser SetUserData bzw. an nachfolgender AddUserData Funktion. Möglich wäre, dass
     * Symfony AddUserData aus irgendwelchem Grund nicht benutzt und deswegen neu erstellte UserData-Objekte nicht in die Collection gespeichert
     * werden. Es kann auch sein, dass es einen Namenkonflikt (UserData) besteht und Symfony irgendwas nicht mappen kann.
     *
     * @param Collection $userData
     * @return $this
     */
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