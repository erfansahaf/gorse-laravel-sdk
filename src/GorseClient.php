<?php

namespace Erfansahaf\GorseLaravelSDK;

use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GorseClient
{
    private PendingRequest $client;

    public function __construct(private readonly string $endpoint, private readonly ?string $apiKey, private readonly ?array $options)
    {
        $this->client = Http::baseUrl($baseURL)
            ->asJson()
            ->acceptJson();
        if ($this->apiKey) {
            $this->client->withHeaders(['X-API-Key' => $this->apiKey]);
        }
        if ($connectTimeout = $this->getOption('connect_timeout')) {
            $this->client->connectTimeout($connectTimeout);
        }
        if ($timeout = $this->getOption('timeout')) {
            $this->client->timeout($timeout);
        }
    }

    public function createUser(string $userId, array $labels, string $comment = "")
    {
        return $this->client->post('user', [
            'UserId' => $userId,
            'Labels' => $labels,
            "Comment" => $comment,
        ]);
    }

    public function updateUser(string $userId, array $labels, string $comment = "")
    {
        return $this->client->patch(sprintf('user/%s', $userId), [
            'Labels' => $labels,
            "Comment" => $comment,
        ]);
    }

    public function createItem(string $itemId, array $categories, array $labels, ?Carbon $timestamp = null, bool $isHidden = false, string $comment = "")
    {
        if ($timestamp === null) {
            $timestamp = now();
        }

        return $this->client->post('item', [
            "ItemId" => $itemId,
            "Categories" => $categories,
            "Comment" => $comment,
            "IsHidden" => $isHidden,
            "Labels" => $labels,
            "Timestamp" => $timestamp->toIso8601String(),
        ]);
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