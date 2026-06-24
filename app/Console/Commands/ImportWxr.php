<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use League\HTMLToMarkdown\HtmlConverter;

class ImportWxr extends Command
{
    protected $signature = 'import:wxr {file : Патека до WXR XML фајлот}';
    protected $description = 'Увоз на WordPress WXR export во базата';

    public function handle(): int
    {
        $path = $this->argument('file');

        if (! file_exists($path)) {
            $this->error("Фајлот не е пронајден: {$path}");
            return self::FAILURE;
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($path, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml === false) {
            $this->error('Грешка при парсирање на XML:');
            foreach (libxml_get_errors() as $error) {
                $this->error('  ' . trim($error->message));
            }
            return self::FAILURE;
        }

        $namespaces = $xml->getNamespaces(true);
        $wpNs      = $namespaces['wp']      ?? 'http://wordpress.org/export/1.2/';
        $contentNs = $namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/';

        $category = Category::firstOrCreate(
            ['slug' => 'business'],
            ['name' => 'Business']
        );

        $converter = new HtmlConverter([
            'header_style' => 'atx',
            'remove_nodes' => 'script style',
            'hard_break'   => false,
        ]);

        $imported = 0;
        $skipped  = 0;

        foreach ($xml->channel->item as $item) {
            $wp      = $item->children($wpNs);
            $content = $item->children($contentNs);

            if ((string) $wp->post_type !== 'post' || (string) $wp->status !== 'publish') {
                continue;
            }

            $title       = (string) $item->title;
            $slug        = (string) $wp->post_name;
            $postDate    = (string) $wp->post_date;
            $htmlContent = (string) $content->encoded;

            if (empty($slug)) {
                continue;
            }

            if (Post::where('slug', $slug)->exists()) {
                $this->line("Прескокнат (веќе постои): {$slug}");
                $skipped++;
                continue;
            }

            // Strip WordPress <!-- more --> separator
            $htmlContent = str_replace(['<!--more-->', '<!-- more -->'], '', $htmlContent);

            // Strip shortcodes: [tag attrs]...[/tag] and standalone [tag] / [tag /]
            $htmlContent = preg_replace('/\[[\w-]+(?:\s[^\]]+)?\].*?\[\/[\w-]+\]/su', '', $htmlContent);
            $htmlContent = preg_replace('/\[\/?[\w-]+(?:\s[^\]]+)?\]/u', '', $htmlContent);

            // Build excerpt from plain text (before HTML→Markdown conversion)
            $plain   = html_entity_decode(strip_tags($htmlContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $plain   = preg_replace('/\s+/', ' ', trim($plain));
            $excerpt = $this->extractExcerpt($plain, 200);

            // Convert HTML → Markdown first (so html-to-markdown handles <img> tags natively)
            $markdown = trim($converter->convert($htmlContent));

            // Then replace WP image URLs in the resulting Markdown
            $markdown = preg_replace_callback(
                '/!\[([^\]]*)\]\(https?:\/\/financebuddy\.mk\/wp-content\/uploads\/([^)]+)\)/',
                fn ($m) => "![{$m[1]}](/storage/uploads/{$m[2]})",
                $markdown
            );

            $publishedAt = (! empty($postDate) && $postDate !== '0000-00-00 00:00:00')
                ? Carbon::parse($postDate)
                : now();

            Post::create([
                'title'               => $title,
                'slug'                => $slug,
                'excerpt'             => $excerpt,
                'content'             => $markdown,
                'featured_image_path' => null,
                'category_id'         => $category->id,
                'author_name'         => 'FinanceBuddy',
                'status'              => 'published',
                'published_at'        => $publishedAt,
                'meta_title'          => null,
                'meta_description'    => null,
                'og_image_path'       => null,
            ]);

            $this->line("Увезен: {$slug}");
            $imported++;
        }

        $this->info("Вкупно: {$imported} увезени, {$skipped} прескокнати");

        return self::SUCCESS;
    }

    private function extractExcerpt(string $text, int $maxLength): string
    {
        // First sentence between 10 and $maxLength chars
        if (preg_match('/^.{10,' . $maxLength . '}[.!?](?:\s|$)/su', $text, $matches)) {
            return trim($matches[0]);
        }

        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }

        // Truncate at word boundary
        $truncated = mb_substr($text, 0, $maxLength);
        $lastSpace = mb_strrpos($truncated, ' ');

        return $lastSpace !== false
            ? mb_substr($truncated, 0, $lastSpace) . '...'
            : $truncated . '...';
    }
}
