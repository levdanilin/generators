<?php

namespace App\Twig;

use App\DTO\MailTo;
use Twig\Extension\RuntimeExtensionInterface;

class MailToRuntime implements RuntimeExtensionInterface
{
    public function generateLink(MailTo $mailToObject): string
    {
        $mailToLink = 'mailto:' . $mailToObject->getAddress();
        $mailToParameters = [];

        if($mailToObject->getSubject() !== null)
        {
            $mailToParameters[] = 'subject=' . $mailToObject->getCc();
        }

        if($mailToObject->getCc() !== null)
        {
            $mailToParameters[] = 'cc=' . $mailToObject->getCc();
        }

        if($mailToObject->getBcc() !== null)
        {
            $mailToParameters[] = 'bcc=' . $mailToObject->getBcc();
        }

        if($mailToObject->getBody() !== null)
        {
            $mailToParameters[] = 'body=' . $mailToObject->getBody();
        }

        if(!empty($mailToParameters))
        {
            $mailToParameters[0] = '?' . $mailToParameters[0];

            if(count($mailToParameters) > 0) {

                for($i = 1; $i < count($mailToParameters); $i++)
                {
                    $mailToParameters[$i] = '&' . $mailToParameters[$i];
                }
                $mailToLink .= http_build_query($mailToParameters);
            }
        }

        return $mailToLink;
    }
}