<?php
/**
 * Description of MessageJobDispatcher.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Dispatchers;

use Dots\MessageBus\Entities\AMPQMessage;

interface MessageJobDispatcher
{
    public function dispatch(AMPQMessage $message): void;
}
