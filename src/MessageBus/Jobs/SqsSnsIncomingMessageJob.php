<?php
/**
 * Description of SqsSnsIncomingMessageJob.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Jobs;

use Dots\MessageBus\Entities\AMPQMessage;
use Dots\MessageBus\Entities\MessagePayload;
use Dots\MessageBus\Handlers\MessageHandlerFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use RuntimeException;

class SqsSnsIncomingMessageJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    private string $subject;

    private array $payload;

    public function middleware(): array
    {
        $key = $this->generateOverlappingKey();
        if (! $key) {
            return [];
        }

        return [
            new WithoutOverlapping(
                $key,
                config('queue.sqs.sqs-sns.overlapping.release_after'),
                config('queue.sqs.sqs-sns.overlapping.expires_after'),
            ),
        ];
    }

    private function generateOverlappingKey(): ?string
    {
        $message = $this->getAMPQMessage();
        if (! $message) {
            return null;
        }

        return $message->getUniqueKey();
    }

    /**
     * @param  string  $subject  SNS Subject
     * @param  array  $payload  JSON decoded 'Message'
     */
    public function __construct(
        string $subject,
        array $payload = []
    ) {
        $this->subject = $subject;
        $this->payload = $payload;
    }

    private function getMessageHandlerFactory(): MessageHandlerFactory
    {
        return app(MessageHandlerFactory::class);
    }

    public function handle(): void
    {
        if (! $this->isNeedToProcess()) {
            return;
        }
        $this->getMessageHandlerFactory()->get($this->subject)->handle(
            $this->createMessagePayload(),
        );
    }

    private function isNeedToProcess(): bool
    {
        try {
            $this->assertPayloadIsValid();
        } catch (RuntimeException $e) {
            info("Can not Process: {$e->getMessage()}");

            return false;
        }

        return true;
    }

    private function assertPayloadIsValid(): void
    {
        if (empty($this->subject)) {
            throw new RuntimeException('Empty subject is not allowed for Incoming Message');
        }
        if (empty($this->payload)) {
            throw new RuntimeException('Empty payload is not allowed for Incoming Message');
        }
    }

    private function createMessagePayload(): MessagePayload
    {
        $message = $this->getAMPQMessage();
        if (! $message) {
            return MessagePayload::fromArray([
                'name' => $this->subject,
                'data' => $this->payload,
            ]);
        }

        return MessagePayload::fromAMPQJob($message);
    }

    private function getAMPQMessage(): ?AMPQMessage
    {
        if (empty($this->payload['data']) || empty($this->payload['routingKey'])) {
            return null;
        }

        return AMPQMessage::fromArray($this->payload);
    }
}
