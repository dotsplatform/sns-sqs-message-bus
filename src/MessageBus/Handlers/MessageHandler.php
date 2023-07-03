<?php
/**
 * Description of MessageHandler.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Handlers;

use Dots\MessageBus\Entities\MessagePayload;

interface MessageHandler
{
    public function handle(MessagePayload $messagePayload): void;
}
