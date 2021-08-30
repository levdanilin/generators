<?php

namespace App\DTO;

class MailTo
{
    private ?string $address = null;
    private ?string $cc = null;
    private ?string $bcc = null;
    private ?string $subject = null;
    private ?string $body = null;
    private ?string $link = null;

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return MailTo
     */
    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return MailTo
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCc(): ?string
    {
        return $this->cc;
    }

    /**
     * @param string|null $cc
     */
    public function setCc(?string $cc): self
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBcc(): ?string
    {
        return $this->bcc;
    }

    /**
     * @param string|null $bcc
     */
    public function setBcc(?string $bcc): self
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

}