<?php

namespace Erfansahaf\GorseLaravelSDK;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GorseClient
{
    private PendingRequest $client;

    public function __construct(private readonly string $endpoint, private readonly ?string $apiKey, private readonly ?array $options)
    {
        $client = Http::baseUrl($baseURL)
            ->asJson()
            ->acceptJson();
        if ($this->apiKey) {
            $client->withHeaders(['X-API-Key' => $this->apiKey]);
        }
        if ($connectTimeout = $this->getOption('connect_timeout')) {
            $client->connectTimeout($connectTimeout);
        }
        if ($timeout = $this->getOption('timeout')) {
            $client->timeout($timeout);
        }
        $this->client = $client;
    }

    public function getUserRecommendation(string $userId, ?string $writeBackType, ?string $writeBackDelay, ?int $n, ?int $offset)
    {
        return $this->client->get(
            sprintf('recommend/%s', $userId),
            $this->unsetNullElements([
                'write-back-type' => $writeBackType,
                'write-back-delay' => $writeBackDelay,
                'n' => $n,
                'offset' => $offset,
            ])
        );
    }

    public function getUserRecommendationByCategory(string $userId, string $category, ?string $writeBackType, ?string $writeBackDelay, ?int $n, ?int $offset)
    {
        return $this->client->get(
            sprintf('recommend/%s/%s', $userId, $category),
            $this->unsetNullElements([
                'write-back-type' => $writeBackType,
                'write-back-delay' => $writeBackDelay,
                'n' => $n,
                'offset' => $offset,
            ])
        );
    }

    protected function getOptions(): array
    {
        return $this->options;
    }

    protected function unsetNullElements(array $list)
    {
        foreach ($list as $key => $value) {
            if (!$value) {
                unset($list[$key]);
            }
        }

        return $list;
    }
}