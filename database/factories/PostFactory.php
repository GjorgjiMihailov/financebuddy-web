<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'excerpt'     => fake()->paragraph(),
            'content'     => "## Вовед\n\n".fake()->paragraphs(3, true),
            'status'      => 'draft',
            'author_name' => 'FinanceBuddy',
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status'       => 'published',
            'published_at' => now()->subDay(),
        ]);
    }
}
