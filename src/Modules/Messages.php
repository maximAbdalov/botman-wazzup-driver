<?php

namespace BotMan\Drivers\WazzupDriver\Modules;

use BotMan\Drivers\WazzupDriver\Dto\MessageRequestDto;
use BotMan\Drivers\WazzupDriver\Exceptions\RequestException;

class Messages extends WazzupModule
{
    protected const API_POINT = 'message/';

    /**
     * @throws RequestException
     */
    public function send(MessageRequestDto $dto): \Psr\Http\Message\ResponseInterface
    {
        return $this->getApi()->post(self::API_POINT, $dto);
    }

    public function delete(string $id): \Psr\Http\Message\ResponseInterface
    {
        return $this->getApi()->delete(static::API_POINT . $id);
    }
}
