<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_posts_list(): void
    {
        $this->actingAs($this->admin)->get('/admin/blog')->assertOk();
    }

    public function test_admin_can_view_create_post_form(): void
    {
        $this->actingAs($this->admin)->get('/admin/blog/novo')->assertOk();
    }

    public function test_admin_can_create_draft_post(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/blog', [
                'title'   => 'Тест пост',
                'slug'    => 'test-post',
                'content' => '## Содржина\n\nОво е тест.',
                'status'  => 'draft',
            ])
            ->assertRedirect('/admin/blog');

        $this->assertDatabaseHas('posts', [
            'slug'   => 'test-post',
            'status' => 'draft',
        ]);
    }

    public function test_draft_post_is_not_visible_on_public_blog(): void
    {
        Post::factory()->create([
            'title'  => 'Нацрт пост',
            'slug'   => 'nacrt-post',
            'status' => 'draft',
        ]);

        $this->get('/blog/nacrt-post')->assertNotFound();
    }

    public function test_published_post_is_visible_on_public_blog(): void
    {
        Post::factory()->create([
            'title'        => 'Објавен пост',
            'slug'         => 'objaven-post',
            'content'      => 'Содржина на постот.',
            'status'       => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog/objaven-post')->assertOk();
    }

    public function test_admin_can_toggle_post_publish_status(): void
    {
        $post = Post::factory()->create(['status' => 'draft']);

        $this->actingAs($this->admin)
            ->patch("/admin/blog/{$post->id}/objavi")
            ->assertRedirect();

        $this->assertEquals('published', $post->fresh()->status);
    }

    public function test_admin_can_delete_post(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($this->admin)
            ->delete("/admin/blog/{$post->id}")
            ->assertRedirect('/admin/blog');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_post_creation_requires_title_and_content(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/blog', ['status' => 'draft'])
            ->assertSessionHasErrors(['title', 'content']);
    }
}
