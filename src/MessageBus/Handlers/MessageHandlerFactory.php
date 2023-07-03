<?php
/**
 * Description of MessageHandlerFactory.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Handlers;

interface MessageHandlerFactory
{
    public function get(string $message): MessageHandler;
}
