<?php

namespace BotMan\Drivers\WazzupDriver\Dto;

class MessageButtonDto
{
    public ?string $text = null;
    public ?string $id = null;
    public ?string $payload = null;
    public string $type = 'text';
}