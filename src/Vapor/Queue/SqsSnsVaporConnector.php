<?php
/**
 * Description of SqsSnsVaporConnector.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\Vapor\Queue;

use Aws\Sqs\SqsClient;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Arr;
use Laravel\Vapor\Queue\VaporConnector;

class SqsSnsVaporConnector extends VaporConnector
{
    /**
     * Establish a queue connection.
     */
    public function connect(array $config): Queue
    {
        $config = $this->getDefaultConfiguration($config);

        if ($config['key'] && $config['secret']) {
            $config['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
        }

        return new SqsSnsVaporQueue(
            new SqsClient($config),
            $config['queue'],
            $config['prefix'] ?? '',
            $config['suffix'] ?? ''
        );
    }
}
