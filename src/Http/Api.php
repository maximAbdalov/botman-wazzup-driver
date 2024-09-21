<?php

namespace BotMan\Drivers\WazzupDriver\Http;

use BotMan\Drivers\WazzupDriver\Exceptions\RequestException;
use BotMan\Drivers\WazzupDriver\Interfaces\WazzupRequestDtoInterface;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Api
{
    private const DEFAULT_BASE_URL = 'https://api.wazzup24.com/v3/';

    private string $token;

    private ClientInterface $httpClient;
    private $baseUrl;

    public function __construct(string $token, ClientInterface $httpClient, $baseUrl = self::DEFAULT_BASE_URL)
    {
        $this->token = $token;
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @throws RequestException
     */
    public function get(string $API_POINT): ResponseInterface
    {
        return $this->request('GET', $this->baseUrl . $API_POINT);
    }

    /**
     * @throws RequestException
     */
    public function post(string $API_POINT, WazzupRequestDtoInterface $frameRequestDto): ResponseInterface
    {
        return $this->request('POST', $this->baseUrl . $API_POINT, $frameRequestDto->toArray());
    }

    /**
     * @throws RequestException
     */
    public function patch(string $API_POINT, WazzupRequestDtoInterface $frameRequestDto): ResponseInterface
    {
        return $this->request('PATCH', $this->baseUrl . $API_POINT, $frameRequestDto->toArray());
    }

    /**
     * @throws RequestException
     */
    public function delete(string $API_POINT): ResponseInterface
    {
        return $this->request('DELETE', $this->baseUrl . $API_POINT);
    }



    protected function getToken(): string
    {
        return $this->token;
    }

    /**
     * @throws RequestException
     */
    public function request(string $type, string $url, array $params = []): ResponseInterface
    {
        $uri = new Uri($url);
        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            if (!empty($this->token)) {
                $headers['Authorization'] = 'Bearer ' . $this->getToken();
            }

            $request = new Request($type, $uri, $headers, json_encode($params));
            return $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new RequestException($e->getMessage(), (int)$e->getCode());
        } catch (\Exception $e) {
            throw new RequestException($e->getMessage(), (int)$e->getCode());
        }
    }
}
