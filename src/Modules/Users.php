<?php

namespace BotMan\Drivers\WazzupDriver\Modules;

use BotMan\Drivers\WazzupDriver\Dto\UserAddRequestDto;
use BotMan\Drivers\WazzupDriver\Exceptions\RequestException;

class Users extends WazzupModuleWithCRUD
{
    protected const API_POINT = 'users/';

}
