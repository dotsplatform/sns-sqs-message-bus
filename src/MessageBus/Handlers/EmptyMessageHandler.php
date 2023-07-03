<?php
/**
 * Description of EmptyMessageHandler.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Handlers;

use Dots\MessageBus\Entities\MessagePayload;

class EmptyMessageHandler implements MessageHandler
{
    public function handle(MessagePayload $messagePayload): void
    {
    }
}
