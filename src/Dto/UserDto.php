<?php

namespace BotMan\Drivers\WazzupDriver\Dto;

use BotMan\Drivers\WazzupDriver\Interfaces\WazzupItemDtoInterface;
use BotMan\Drivers\WazzupDriver\Interfaces\WazzupRequestDtoInterface;

class UserDto implements WazzupItemDtoInterface
{
    public string $id;
    public string $name;
    public ?string $phone = null;

    public function toArray(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }

    public static function createFromWazzup(array $user): UserDto
    {
        $self        = new self();
        $self->id    = $user['id'];
        $self->name  = $user['name'];
        $self->phone = $user['phone'] ?? null;
        return $self;
    }
}