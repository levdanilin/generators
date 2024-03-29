<?php

namespace App\DTO;

class MailTo
{
    private ?string $address = null;
    private ?string $cc = null;
    private ?string $bcc = null;
    private ?string $subject = null;
    private ?string $body = null;

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
     * @return MailTo
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
     * @return MailTo
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
     * @return MailTo
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
     * @return MailTo
     */
    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

}