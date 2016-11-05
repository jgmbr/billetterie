<?php

namespace AppBundle\Services\Mailer;

use Symfony\Component\Templating\EngineInterface;

class NotificationMailer
{
    private $mailer;

    private $templating;

  public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
  {
    $this->mailer = $mailer;

    $this->templating = $templating;
  }

  public function sendEmail($datas)
  {
      if (!$datas)
          return false;

      $message = \Swift_Message::newInstance()
          ->setSubject($datas['subject'])
          ->setFrom($datas['from'])
          ->setTo($datas['to'])
          ->setBody($this->templating->render($datas['template'],$datas['content']))
          ->setContentType('text/html')
      ;

      if (!empty($datas['image']))
        $message->embed(\Swift_Image::fromPath($datas['image']));

      if (!empty($datas['attachment']))
        $message->attach(\Swift_Attachment::fromPath($datas['attachment']));

      if ($this->mailer->send($message))
          return true;
      else
          return false;

  }
}
