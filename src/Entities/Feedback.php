<?php

namespace Erfansahaf\GorseLaravel\Entities;

use Carbon\Carbon;

class Feedback
{
    public function __construct(private readonly string $userId, private readonly string $itemId, private readonly string $type, private readonly Carbon $timestamp, private readonly ?string $comment = null)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTimestamp(): Carbon
    {
        return $this->timestamp;
    }

    public function getTimestampIso8601(): string
    {
        return $this->timestamp->toIso8601String();
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}