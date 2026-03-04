<?php

namespace OrvexPay\Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use OrvexPay\Sdk\Exceptions\OrvexException;

class OrvexClient
{
    protected Client $httpClient;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, ?string $baseUrl = null)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl ?? 'https://api.orvexpay.com';

        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => 30.0,
        ]);
    }

    /**
     * @param array $params
     * @return array
     * @throws OrvexException
     */
    public function createInvoice(array $params): array
    {
        return $this->request('POST', '/api/invoice', [
            'json' => $params
        ]);
    }

    /**
     * @param string $id
     * @return array
     * @throws OrvexException
     */
    public function getInvoice(string $id): array
    {
        return $this->request('GET', "/api/invoice/{$id}");
    }

    /**
     * @param string $id
     * @param string $newCurrency
     * @return array
     * @throws OrvexException
     */
    public function updateInvoiceCurrency(string $id, string $newCurrency): array
    {
        return $this->request('PUT', "/api/invoice/{$id}/currency", [
            'body' => json_encode($newCurrency)
        ]);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     * @throws OrvexException
     */
    protected function request(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->httpClient->request($method, $uri, $options);
            $content = (string) $response->getBody();

            return json_decode($content, true);
        } catch (GuzzleException $e) {
            $response = method_exists($e, 'getResponse') ? $e->getResponse() : null;
            $body = $response ? (string) $response->getBody() : null;
            $data = $body ? json_decode($body, true) : null;

            $message = $data['message'] ?? $e->getMessage();
            throw new OrvexException("OrvexPay API Error: {$message}", $response ? $response->getStatusCode() : 0, $data);
        }
    }
}
