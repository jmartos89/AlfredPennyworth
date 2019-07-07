<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * User "/crypto" command
 *
 * Simply echo the input back to the user.
 */
class CryptoCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'crypto';

    /**
     * @var string
     */
    protected $description = 'crypto';

    /**
     * @var string
     */
    protected $usage = '/crypto';

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

        $kernel = new Kernel('prod', false);

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'ap:crypto-coins',
            // (optional) define the value of command arguments
        ]);

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        $msg = $output->fetch();

        $data = [
            'parse_mode' => 'HTML',
            'chat_id' => $chat_id,
            'text'    => $msg,
        ];

        return Request::sendMessage($data);
    }
}
