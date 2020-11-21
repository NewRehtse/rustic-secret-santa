<?php


use Application\EmailGenerator;
use Application\Raffle;
use Model\Participants;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$json = \file_get_contents(__DIR__.'/participants.json');

if (false === $json) {
    echo "ERROR: File does not exists";
    return;
}

$data = \json_decode($json, true);

if (null === $data) {
    echo "ERROR: File does not contains valid json";
    return;
}

$details = $data['details'] ?? '';
$participansData = $data['participants'] ?? [];

$participans = Participants::buildFromArray($participansData);

try {
    $santa = new Raffle($participans);
    $associations = $santa->getAssociations();
} catch (\Exception $e) {
    echo $e->getMessage();
    return;
}

$templateMessage = \file_get_contents(__DIR__.'/email-template.html');
if (false === $templateMessage) {
    echo "ERROR: Template not found";
    return;
}

$sender = new EmailGenerator($templateMessage);
$sender->setDetails($details);
$emails = $sender->getEmails($associations);

$transport = new Swift_SmtpTransport($_ENV['SMTP_SERVER'], $_ENV['SMTP_PORT'], "ssl");
$transport->setUsername($_ENV['SMTP_USERNAME']);
$transport->setPassword($_ENV['SMTP_PASSWORD']);

$mailer = new Swift_Mailer($transport);


foreach($emails as $email) {
    $message = new Swift_Message($email->subject(), $email->body(), 'text/html');
    $message->setTo($email->to());
    $message->setFrom($email->to());

    $result = $mailer->send($message);
    if ($result === 0) {
        echo "ERROR: There has been an error with: ".$email->to();
        return;
    }
}

