<?php

namespace BotMan\Drivers\WazzupDriver;

use BotMan\BotMan\Drivers\HttpDriver;
use BotMan\BotMan\Interfaces\WebAccess;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Users\User;
use BotMan\Drivers\WazzupDriver\Dto\MessageButtonDto;
use BotMan\Drivers\WazzupDriver\Dto\MessageRequestDto;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class WhatsAppDriver extends HttpDriver
{
    /**
     * @const string
     */
    const DRIVER_NAME = 'WhatsApp';
    const CHAT_TYPE = 'whatsapp';
    /**
     * @var string
     */
    protected $endpoint = 'message';

    /**
     * @var array
     */
    protected $messages = [];

    private $chanelId;

    /**
     * @var Client $wazzupClient
     */
    private $wazzupClient;
    /**
     * @param Request $request
     */
    public function buildPayload(Request $request)
    {
        $rawPayload = json_decode($request->getContent(), true);
        $this->payload = new ParameterBag(Arr::get($rawPayload, 'messages', [])[0] ?? []);
        $this->event = Collection::make($this->payload->all());
        $this->signature = $this->payload->get('messageId');
        $this->content = $request->getContent();
        $this->config = Collection::make($this->config->get('whatsapp', []));
        $this->wazzupClient = new Client(
            $this->config['token'],
            new \GuzzleHttp\Client(),
            $this->config['url']);
        $this->chanelId = $this->config['chanel_id'];
    }

    public function isConfigured()
    {
        return !empty($this->config->get('url')) && !empty($this->config->get('token'));
    }

    public function matchesRequest()
    {
        return !is_null($this->payload->get('chatType'))
            && $this->payload->get('chatType') == 'whatsapp'
            && $this->payload->get('isEcho') == false
            && $this->payload->get('channelId') == $this->chanelId;
    }

    /**
     * Retrieve the chat message.
     *
     * @return array
     */
    public function getMessages()
    {
        if (empty($this->messages)) {
            $message = $this->event->get('text');
            $userId = $this->event->get('chatId');
            $this->messages = [new IncomingMessage($message, $userId, $userId, $this->payload)];
        }
        return $this->messages;
    }

    public function getUser(IncomingMessage $matchingMessage)
    {
        return new User($matchingMessage->getSender());
    }

    /**
     * @param IncomingMessage $message
     * @return \BotMan\BotMan\Messages\Incoming\Answer
     */
    public function getConversationAnswer(IncomingMessage $message)
    {
        return Answer::create($message->getText())->setMessage($message);
    }

    /**
     * @param string|Question|OutgoingMessage $message
     * @param IncomingMessage $matchingMessage
     * @param array $additionalParameters
     */
    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        if (! $message instanceof WebAccess && ! $message instanceof OutgoingMessage) {
            $this->errorMessage = 'Unsupported message type.';
            $this->replyStatusCode = 500;
        }

        $dtoMessage = new MessageRequestDto();
        $dtoMessage->text = strip_tags($message->getText());
        $dtoMessage->chatId = $matchingMessage->getRecipient();
        $dtoMessage->channelId = $this->chanelId;
        $dtoMessage->chatType = self::CHAT_TYPE;
        if ($message instanceof OutgoingMessage && $attachment = $message->getAttachment()) {
            $dtoMessage->text = null;
            $dtoMessage->contentUri = $attachment->getUrl();
        }
        if ($message instanceof Question && $buttons = $message->getButtons()) {
            $buttons = array_slice($buttons, 0, 10);
            foreach ($buttons as $btn) {
                $button = new MessageButtonDto();
                $button->text = Str::limit(Arr::get($btn, 'text'), 16, '..');
                $button->type = 'text';
                $dtoMessage->addButton($button);
            }
        }

        return [
            'message' => $dtoMessage,
            'additionalParameters' => $additionalParameters,
        ];
    }

    /**
     * @param mixed $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendPayload($payload)
    {
        return $this->wazzupClient->messages()->send($payload['message']);
    }

    public function sendRequest($endpoint, array $parameters, IncomingMessage $matchingMessage)
    {
        $parameters = array_replace_recursive([
            'chatId' => $matchingMessage->getRecipient(),
        ], $parameters);

        $result = $this->sendPayload($parameters);
        return $result;

    }
}
