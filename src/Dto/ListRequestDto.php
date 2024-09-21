<?php

namespace BotMan\Drivers\WazzupDriver\Dto;

use BotMan\Drivers\WazzupDriver\Interfaces\WazzupItemDtoInterface;
use BotMan\Drivers\WazzupDriver\Interfaces\WazzupRequestDtoInterface;

class ListRequestDto implements WazzupRequestDtoInterface
{
    public array $items = [];

    public function push(WazzupItemDtoInterface $item): ListRequestDto
    {
        $this->items[] = $item;
        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }

}