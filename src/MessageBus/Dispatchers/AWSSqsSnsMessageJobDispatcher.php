<?php
/**
 * Description of AWSSqsSnsMessageJobDispatcher.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Dispatchers;

use Aws\Sns\SnsClient;
use Dots\MessageBus\Entities\AMPQMessage;

class AWSSqsSnsMessageJobDispatcher implements MessageJobDispatcher
{
    private SnsClient $snsClient;

    public function __construct(
        SnsClient $snsClient
    ) {
        $this->snsClient = $snsClient;
    }

    public function dispatch(AMPQMessage $message): void
    {
        $this->snsClient->publish([
            'TopicArn' => $message->getRoutingKey(),
            'Message' => json_encode($message->toArray()),
            'Subject' => $message->getName(),
        ]);
    }
}
