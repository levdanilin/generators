<?php

namespace App\Twig;

use App\DTO\MailTo;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MailToExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('mailToLinkGenerator', [$this, 'generateLink']),
        ];
    }

    public function generateLink(MailTo $mailToObject): string
    {
        $mailToLink = 'mailto:' . $mailToObject->getAddress();
        $mailToParameters = [];

        if($mailToObject->getSubject() !== null)
        {
            $mailToParameters['subject'] = $mailToObject->getSubject();
        }

        if($mailToObject->getCc() !== null)
        {
            $mailToParameters['cc'] = $mailToObject->getCc();
        }

        if($mailToObject->getBcc() !== null)
        {
            $mailToParameters['bcc'] = $mailToObject->getBcc();
        }

        if($mailToObject->getBody() !== null)
        {
            $mailToParameters['body'] = $mailToObject->getBody();
        }

        if(count($mailToParameters) > 0)
        {
            $mailToLink .= '?' . http_build_query($mailToParameters);
        }
        return $mailToLink;
    }
}