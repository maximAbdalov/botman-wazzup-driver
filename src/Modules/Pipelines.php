<?php

namespace BotMan\Drivers\WazzupDriver\Modules;

use BotMan\Drivers\WazzupDriver\Dto\ListRequestDto;
use BotMan\Drivers\WazzupDriver\Dto\PipelineDto;
use BotMan\Drivers\WazzupDriver\Dto\PipelinesRequestDto;

class Pipelines extends WazzupModule
{
    protected const API_POINT = 'pipelines/';

    public function getList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->getApi()->get(self::API_POINT);
    }

    public function store(ListRequestDto $dto): \Psr\Http\Message\ResponseInterface
    {
        return $this->getApi()->post(self::API_POINT, $dto);
    }
}
