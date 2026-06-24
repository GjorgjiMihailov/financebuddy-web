<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdown\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'category_id',
        'author_name',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'og_image_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = ['reading_time'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function getReadingTimeAttribute(): int
    {
        $text = strip_tags($this->content ?? '');
        $words = preg_split('/\s+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);

        return max(1, (int) ceil(count($words) / 200));
    }

    public function getHtmlContentAttribute(): string
    {
        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        return (string) (new MarkdownConverter($environment))->convert($this->content ?? '');
    }
}
