<?php

namespace BotMan\Drivers\WazzupDriver\Modules;

use BotMan\Drivers\WazzupDriver\Dto\IFrameRequestDto;
use BotMan\Drivers\WazzupDriver\Exceptions\RequestException;

class IFrame extends WazzupModule
{
    protected const API_POINT = 'iframe/';

    /**
     * @throws RequestException
     */
    public function getFrame(IFrameRequestDto $frameRequestDto): \Psr\Http\Message\ResponseInterface
    {
        return $this->getApi()->post(self::API_POINT, $frameRequestDto);
    }
}
