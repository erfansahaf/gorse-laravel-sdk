<?php

namespace Erfansahaf\GorseLaravel;

use Carbon\Carbon;
use Erfansahaf\GorseLaravel\Entities\Item;
use Erfansahaf\GorseLaravel\Entities\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GorseClient
{
    private PendingRequest $client;

    public function __construct(private readonly string $endpoint, private readonly ?string $apiKey, private readonly ?array $options)
    {
        $this->endpoint = rtrim($this->endpoint, '/');
        if (!Str::endsWith('api')) {
            $this->endpoint = sprintf('%s/api', $this->endpoint);
        }
        $this->client = Http::baseUrl($this->endpoint)
            ->connectTimeout($this->getOption('connect_timeout'))
            ->timeout($this->getOption('timeout'))
            ->asJson()
            ->acceptJson();
        if ($this->apiKey) {
            $this->client->withHeaders(['X-API-Key' => $this->apiKey]);
        }
    }

    public function createUser(User $user)
    {
        return $this->client->post(
            'user',
            $this->unsetNullElements([
                'UserId' => $user->getId(),
                'Labels' => $user->getLabels(),
                "Comment" => $user->getComment(),
            ])
        );
    }

    public function updateUser(User $user)
    {
        return $this->client->patch(
            sprintf('user/%s', $user->getId()),
            $this->unsetNullElements([
                'Labels' => $user->getLabels(),
                "Comment" => $user->getComment(),
            ])
        );
    }

    public function createItem(Item $item)
    {
        return $this->client->post(
            'item',
            $this->unsetNullElements([
                "ItemId" => $item->getId(),
                "Categories" => $item->getCategories(),
                "Comment" => $item->getComment(),
                "IsHidden" => $item->isHidden(),
                "Labels" => $item->getLabels(),
                "Timestamp" => $item->getTimestampIso8601(),
            ])
        );
    }

    public function updateItem(Item $item)
    {
        return $this->client->patch(
            sprintf('item/%s', $item->getId()),
            $this->unsetNullElements([
                "Categories" => $item->getCategories(),
                "Comment" => $item->getComment(),
                "IsHidden" => $item->isHidden(),
                "Labels" => $item->getLabels(),
                "Timestamp" => $item->getTimestampIso8601(),
            ])
        );
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
            if ($value === null) {
                unset($list[$key]);
            }
        }

        return $list;
    }
}