<?php

namespace Erfansahaf\GorseLaravel\Entities;

class User
{
    public function __construct(private readonly string $id, private readonly ?array $labels, private readonly ?string $comment = "")
    {
    }

    public function getId(): string
    {
        return $this->userId;
    }

    public function getLabels(): ?array
    {
        return $this->labels;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}