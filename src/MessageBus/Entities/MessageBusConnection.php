<?php
/**
 * Description of MessageBusProvider.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Entities;

abstract class MessageBusConnection
{
    public const SQS_SNS = 'sqs-sns';
}
