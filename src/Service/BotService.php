<?php

namespace App\Service;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class BotService
{
    private $telegramApiKey;
    private $telegramUser;
    private $telegramHookURL;

    public function __construct($telegramApiKey, $telegramUser, $telegramHookURL)
    {
        $this->telegramApiKey = $telegramApiKey;
        $this->telegramUser = $telegramUser;
        $this->telegramHookURL = $telegramHookURL;
    }

    public function set()
    {
        $msg = '';
        try {
            // Create Telegram API object
            $telegram = new Telegram($this->telegramApiKey, $this->telegramUser);

            // Set webhook
            $result = $telegram->setWebhook($this->telegramHookURL);

            if ($result->isOk()) {
                $msg = $result->getDescription();
            }
        } catch (TelegramException $exception) {
            // log telegram errors
            $msg = $exception->getMessage();
        }

        return $msg;
    }

    public function unset()
    {
        $msg = '';
        try {
            // Create Telegram API object
            $telegram = new Telegram($this->telegramApiKey, $this->telegramUser);

            // Delete webhook
            $result = $telegram->deleteWebhook();

            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $exception) {
            // log telegram errors
            $msg = $exception->getMessage();
        }

        return $msg;
    }

    public function hook()
    {
        $msg = '';
        try {
            // Create Telegram API object
            $telegram = new Telegram($this->telegramApiKey, $this->telegramUser);

            //TODO: Change this
            $commands = ['/home/app/bot/Commands/'];

            TelegramLog::initialize(
                new Logger('telegram_bot', [
                    (new StreamHandler(
                        __DIR__ . "/../../var/log/{$this->telegramUser}_debug.log",
                        Logger::DEBUG))->setFormatter(new LineFormatter(null, null, true)
                    ),
                    (new StreamHandler(
                        __DIR__ . "/../../var/log/{$this->telegramUser}_error.log",
                        Logger::ERROR))->setFormatter(new LineFormatter(null, null, true)
                    ),
                ]),

                new Logger('telegram_bot_updates', [
                    (new StreamHandler(
                        __DIR__ . "/../../var/log/{$this->telegramUser}_update.log",
                        Logger::INFO))->setFormatter(new LineFormatter('%message%' . PHP_EOL)
                    ),
                ])
            );

            //Add Commands
            $telegram->addCommandsPaths($commands);
            $telegram->handle();

            $msg = 'handle';
        } catch (TelegramException $e) {
            // Silence is golden!
            //echo $e;
            // Log telegram errors
            TelegramLog::error($e);
        } catch (TelegramLogException $e) {
            // Silence is golden!
            // Uncomment this to catch log initialisation errors
            //echo $e;
        }

        return $msg;
    }
}
