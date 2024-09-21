<?php

namespace BotMan\Drivers\WazzupDriver\Modules;

use BotMan\Drivers\WazzupDriver\Dto\ListRequestDto;
use BotMan\Drivers\WazzupDriver\Exceptions\RequestException;

class Deals extends WazzupModuleWithCRUD
{
    protected const API_POINT = 'deals/';

}
