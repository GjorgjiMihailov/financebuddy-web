<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $sitemap = Sitemap::create();

        // Статични страни
        $staticPages = [
            ['loc' => '/',         'priority' => '1.0',  'changefreq' => 'weekly'],
            ['loc' => '/za-nas',   'priority' => '0.8',  'changefreq' => 'monthly'],
            ['loc' => '/uslugi',   'priority' => '0.9',  'changefreq' => 'monthly'],
            ['loc' => '/blog',     'priority' => '0.8',  'changefreq' => 'daily'],
            ['loc' => '/faq',      'priority' => '0.7',  'changefreq' => 'monthly'],
            ['loc' => '/kariera',  'priority' => '0.5',  'changefreq' => 'monthly'],
            ['loc' => '/kontakt',  'priority' => '0.7',  'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create('https://financebuddy.mk'.$page['loc'])
                    ->setPriority((float) $page['priority'])
                    ->setChangeFrequency($page['changefreq'])
            );
        }

        // Услуги — поединечни страни
        $serviceSlugs = [
            'finansisko-smetkovodstvo',
            'materijalno-smetkovodstvo',
            'danocen-konsalting',
            'registracija-firma',
            'presmetka-na-plati',
            'finansiski-izvestai',
            'konsalting-za-msp',
            'danocna-optimizacija',
        ];

        foreach ($serviceSlugs as $slug) {
            $sitemap->add(
                Url::create("https://financebuddy.mk/uslugi/{$slug}")
                    ->setPriority(0.8)
                    ->setChangeFrequency('monthly')
            );
        }

        // Blog постови (само публикувани)
        Post::published()
            ->select(['slug', 'updated_at'])
            ->orderByDesc('published_at')
            ->each(function (Post $post) use ($sitemap) {
                $sitemap->add(
                    Url::create("https://financebuddy.mk/blog/{$post->slug}")
                        ->setLastModificationDate(Carbon::parse($post->updated_at))
                        ->setPriority(0.7)
                        ->setChangeFrequency('monthly')
                );
            });

        return $sitemap->toResponse(request());
    }
}
