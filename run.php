<?php

$firstArgument = $argv[1] ?? null;
$relaunch = false;
if ($firstArgument && $firstArgument === 'relaunch') {
    $relaunch = true;
}


require_once __DIR__.'/vendor/autoload.php';

use Application\NotificationGenerator;
use Application\SecretSantaHandler;
use Infrastructure\MailjetMailer;
use Infrastructure\ParticipantsFileRepository;
use Infrastructure\SavedSecretSantaFileRepository;



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$repository = new ParticipantsFileRepository(__DIR__.'/participants.json');
//Use MailjetMailer if MAILJET_API_KEY and MAILJET_API_SECRET are configured
$mailer = new MailjetMailer(
    $_ENV['MAILJET_API_KEY'],
    $_ENV['MAILJET_API_SECRET'],
    $_ENV['MAILJET_FROM_EMAIL']
);
//Use NotificationMailer if SMTP_SERVER, SMTP_PORT, SMTP_USERNAME and SMTP_PASSWORD are configured
/*
$mailer = new NotificationMailer(
    $_ENV['SMTP_SERVER'],
    $_ENV['SMTP_PORT'],
    $_ENV['SMTP_USERNAME'],
    $_ENV['SMTP_PASSWORD']
);
 */
$sender = NotificationGenerator::buildFromFile(__DIR__.'/email-template.html');
$savedSecretSantaRepository = new SavedSecretSantaFileRepository(__DIR__.'/saved-secret-santa');
$secretSanta = new SecretSantaHandler($repository, $mailer, $sender, $savedSecretSantaRepository);

try {
    $relaunch ? $secretSanta->cachedSecretSanta() : $secretSanta->secretSanta();
} catch(Exception $e) {
    echo $e->getMessage();
}

