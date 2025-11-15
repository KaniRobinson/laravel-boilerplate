<?php

namespace Database\Factories;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * The model that should be used for the factory.
     *
     * @var class-string<Message>
     */
    protected string $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => User::factory(),
            'recipient_id' => User::factory(),
            'conversation_id' => function (array $attributes): string {
                return Uuid::uuid5(Uuid::NAMESPACE_URL, sprintf('%s-%s', min($attributes['sender_id'], $attributes['recipient_id']), max($attributes['sender_id'], $attributes['recipient_id'])));
            },
            'body' => $this->faker->realText(120),
            'read_at' => null,
        ];
    }

    /**
     * Indicate that the message has been read.
     *
     * @return static
     */
    public function read(): static
    {
        return $this->state(fn (): array => [
            'read_at' => now(),
        ]);
    }
}

