<?php

namespace App\DTO;

class TaskData
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $status = 'pending',
        public int $user_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status'] ?? 'pending',
            user_id: $data['user_id']
        );
    }
}
