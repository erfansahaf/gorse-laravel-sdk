<?php

namespace Erfansahaf\GorseLaravel\Entities;

use Carbon\Carbon;

class Item
{
    public function __construct(private readonly string $id, private readonly ?array $categories, private readonly ?array $labels, private readonly ?Carbon $timestamp = null, private readonly bool $isHidden = false, private readonly ?string $comment = "")
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function getLabels(): ?array
    {
        return $this->labels;
    }

    public function getTimestamp(): ?Carbon
    {
        return $this->timestamp;
    }

    public function getTimestampIso8601(): ?string
    {
        return $this->timestamp?->toIso8601String();
    }

    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}