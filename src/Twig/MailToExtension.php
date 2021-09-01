<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MailToExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('mailToLinkGenerator', [MailToRuntime::class, 'generateLink']),
        ];
    }

}