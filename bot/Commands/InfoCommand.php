<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * User "/info" command
 *
 * Simply echo the input back to the user.
 */
class InfoCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'info';

    /**
     * @var string
     */
    protected $description = 'info';

    /**
     * @var string
     */
    protected $usage = '/info';

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

        $msg = 'info test';

        $data = [
            'chat_id' => $chat_id,
            'text'    => $msg,
        ];

        return Request::sendMessage($data);
    }
}
