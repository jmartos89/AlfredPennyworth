<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * User "/start" command
 *
 * Simply echo the input back to the user.
 */
class StartCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'info';

    /**
     * @var string
     */
    protected $description = 'start';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $msg = 'Bienvenido señor' . PHP_EOL;

        $data = [
            'parse_mode' => 'HTML',
            'chat_id' => $chat_id,
            'text'    => $msg,
        ];

        return Request::sendMessage($data);
    }
}
