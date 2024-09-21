<?php

namespace BotMan\Drivers\WazzupDriver\Dto;

class IFrameOptionsDto
{
    public ?string $clientType = null;
    public bool $useDealsEvents = false;
    public bool $useMessageEvents = false;
}