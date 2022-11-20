<?php

$firstArgument = $argv[1] ?? null;
$relaunch = false;
if ($firstArgument && $firstArgument === 'relaunch') {
    $relaunch = true;
}


use Application\NotificationGenerator;
use Application\SecretSantaHandler;
use Inrastructure\NotificationMailer;
use Inrastructure\ParticipantsFileRepository;
use Inrastructure\SavedSecretSantaFileRepository;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$repository = new ParticipantsFileRepository(__DIR__.'/participants.json');
$mailer = new NotificationMailer(
    $_ENV['SMTP_SERVER'],
    $_ENV['SMTP_PORT'],
    $_ENV['SMTP_USERNAME'],
    $_ENV['SMTP_PASSWORD']
);
$sender = NotificationGenerator::buildFromFile(__DIR__.'/email-template.html');
$savedSecretSantaRepository = new SavedSecretSantaFileRepository(__DIR__.'/saved-secret-santa');
$secretSanta = new SecretSantaHandler($repository, $mailer, $sender, $savedSecretSantaRepository);

try {
    $relaunch ? $secretSanta->cachedSecretSanta() : $secretSanta->secretSanta();
} catch(Exception $e) {
    echo $e->getMessage();
}

