<?php

namespace BotMan\Drivers\WazzupDriver;

use BotMan\Drivers\WazzupDriver\Modules\Channels;
use BotMan\Drivers\WazzupDriver\Modules\Contacts;
use BotMan\Drivers\WazzupDriver\Modules\Counters;
use BotMan\Drivers\WazzupDriver\Modules\Deals;
use BotMan\Drivers\WazzupDriver\Modules\IFrame;
use BotMan\Drivers\WazzupDriver\Http\Api;
use BotMan\Drivers\WazzupDriver\Modules\Messages;
use BotMan\Drivers\WazzupDriver\Modules\Pipelines;
use BotMan\Drivers\WazzupDriver\Modules\Users;
use BotMan\Drivers\WazzupDriver\Modules\Webhooks;
use Psr\Http\Client\ClientInterface;

class Client
{
    private Api $api;

    private IFrame $iframe;
    private Users $users;
    private Pipelines $pipelines;
    private Contacts $contacts;
    private Deals $deals;
    private Webhooks $webhooks;
    private Channels $channels;
    private Messages $messages;
    private Counters $counters;

    public function __construct(string $authToken, ClientInterface $client, string $baseUrl)
    {
        $this->api       = new Api($authToken, $client, $baseUrl);
        $this->iframe    = new IFrame($this->api);
        $this->users     = new Users($this->api);
        $this->pipelines = new Pipelines($this->api);
        $this->contacts  = new Contacts($this->api);
        $this->deals     = new Deals($this->api);
        $this->webhooks  = new Webhooks($this->api);
        $this->channels  = new Channels($this->api);
        $this->messages  = new Messages($this->api);
        $this->counters  = new Counters($authToken, $this->api);

    }

    protected function getApi(): Api
    {
        return $this->api;
    }

    public function iframe(): IFrame
    {
        return $this->iframe;
    }

    public function users(): Users
    {
        return $this->users;
    }

    public function pipelines(): Pipelines
    {
        return $this->pipelines;
    }

    public function contacts(): Contacts
    {
        return $this->contacts;
    }

    public function deals(): Deals
    {
        return $this->deals;
    }

    public function webhooks(): Webhooks
    {
        return $this->webhooks;
    }

    public function channels(): Channels
    {
        return $this->channels;
    }

    public function messages(): Messages
    {
        return $this->messages;
    }

    public function counters(): Counters
    {
        return $this->counters;
    }
}
