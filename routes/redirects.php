<?php

use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────
// 301 Permanent redirects — стари WordPress URL-ови → нови Laravel рути
// Критично за зачувување на постоечкиот SEO ranking при миграција.
// ─────────────────────────────────────────────────────────────────

// Главни страни (патеки со trailing slash и алтернативни имиња)
Route::redirect('/about',        '/za-nas', 301);
Route::redirect('/about/',       '/za-nas', 301);
Route::redirect('/services',     '/uslugi', 301);
Route::redirect('/services/',    '/uslugi', 301);
Route::redirect('/contact',      '/kontakt', 301);
Route::redirect('/contact/',     '/kontakt', 301);
Route::redirect('/career',       '/kariera', 301);
Route::redirect('/career/',      '/kariera', 301);
Route::redirect('/financeblog',  '/blog', 301);
Route::redirect('/financeblog/', '/blog', 301);

// Trailing slash на нови рути (Google индексира без slash)
Route::redirect('/za-nas/',   '/za-nas', 301);
Route::redirect('/uslugi/',   '/uslugi', 301);
Route::redirect('/blog/',     '/blog', 301);
Route::redirect('/faq/',      '/faq', 301);
Route::redirect('/kariera/',  '/kariera', 301);
Route::redirect('/kontakt/',  '/kontakt', 301);

// ─────────────────────────────────────────────────────────────────
// Blog постови — стари root-level URL-ови → нови /blog/{slug} URL-ови
// Извор на slug-ови: 01-CONTENT-AUDIT.md §9 (FB#1–FB#20)
// ─────────────────────────────────────────────────────────────────
Route::redirect('/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat',   '/blog/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat', 301);
Route::redirect('/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat/',  '/blog/generaciski-razliki-na-rabotnoto-mesto-kako-da-se-motiviraat', 301);
Route::redirect('/zosto-najdobrite-menadzeri-se-poveke-od-samo-brojki',             '/blog/zosto-najdobrite-menadzeri-se-poveke-od-samo-brojki', 301);
Route::redirect('/zosto-najdobrite-menadzeri-se-poveke-od-samo-brojki/',            '/blog/zosto-najdobrite-menadzeri-se-poveke-od-samo-brojki', 301);
Route::redirect('/stres-na-rabotno-mesto-koga-stanuva-praven-problem',              '/blog/stres-na-rabotno-mesto-koga-stanuva-praven-problem', 301);
Route::redirect('/stres-na-rabotno-mesto-koga-stanuva-praven-problem/',             '/blog/stres-na-rabotno-mesto-koga-stanuva-praven-problem', 301);
Route::redirect('/piramidalni-i-ponzi-semi-kako-da-gi-prepoznaete-fb17',            '/blog/piramidalni-i-ponzi-semi-kako-da-gi-prepoznaete-fb17', 301);
Route::redirect('/piramidalni-i-ponzi-semi-kako-da-gi-prepoznaete-fb17/',           '/blog/piramidalni-i-ponzi-semi-kako-da-gi-prepoznaete-fb17', 301);
Route::redirect('/dali-si-toksicen-lider-5-znaci-za-promena-na-percepcijata-fb16', '/blog/dali-si-toksicen-lider-5-znaci-za-promena-na-percepcijata-fb16', 301);
Route::redirect('/dali-si-toksicen-lider-5-znaci-za-promena-na-percepcijata-fb16/','/blog/dali-si-toksicen-lider-5-znaci-za-promena-na-percepcijata-fb16', 301);
Route::redirect('/magijata-na-kafeto-kako-malite-trosoci-go-jadat-budzetot-fb15',  '/blog/magijata-na-kafeto-kako-malite-trosoci-go-jadat-budzetot-fb15', 301);
Route::redirect('/magijata-na-kafeto-kako-malite-trosoci-go-jadat-budzetot-fb15/', '/blog/magijata-na-kafeto-kako-malite-trosoci-go-jadat-budzetot-fb15', 301);
Route::redirect('/due-diligence-kluc-za-uspeh-na-start-up-kompaniite-fb14',        '/blog/due-diligence-kluc-za-uspeh-na-start-up-kompaniite-fb14', 301);
Route::redirect('/due-diligence-kluc-za-uspeh-na-start-up-kompaniite-fb14/',       '/blog/due-diligence-kluc-za-uspeh-na-start-up-kompaniite-fb14', 301);
Route::redirect('/tiktok-finansiski-gurua-dali-se-za-veruvanje-fb13',              '/blog/tiktok-finansiski-gurua-dali-se-za-veruvanje-fb13', 301);
Route::redirect('/tiktok-finansiski-gurua-dali-se-za-veruvanje-fb13/',             '/blog/tiktok-finansiski-gurua-dali-se-za-veruvanje-fb13', 301);
Route::redirect('/venture-capital-dali-e-korisen-za-freelancer-fb12',              '/blog/venture-capital-dali-e-korisen-za-freelancer-fb12', 301);
Route::redirect('/venture-capital-dali-e-korisen-za-freelancer-fb12/',             '/blog/venture-capital-dali-e-korisen-za-freelancer-fb12', 301);
Route::redirect('/poteklo-na-imot-pari-pod-dusek-fb11',                            '/blog/poteklo-na-imot-pari-pod-dusek-fb11', 301);
Route::redirect('/poteklo-na-imot-pari-pod-dusek-fb11/',                           '/blog/poteklo-na-imot-pari-pod-dusek-fb11', 301);
Route::redirect('/payoneer-dali-ujp-moze-da-go-kontrolira-fb10',                   '/blog/payoneer-dali-ujp-moze-da-go-kontrolira-fb10', 301);
Route::redirect('/payoneer-dali-ujp-moze-da-go-kontrolira-fb10/',                  '/blog/payoneer-dali-ujp-moze-da-go-kontrolira-fb10', 301);
Route::redirect('/licen-bankrot-dali-ni-e-potreben-fb9',                           '/blog/licen-bankrot-dali-ni-e-potreben-fb9', 301);
Route::redirect('/licen-bankrot-dali-ni-e-potreben-fb9/',                          '/blog/licen-bankrot-dali-ni-e-potreben-fb9', 301);
Route::redirect('/otkaz-prava-i-obvrski-vo-otkazen-rok-fb8',                       '/blog/otkaz-prava-i-obvrski-vo-otkazen-rok-fb8', 301);
Route::redirect('/otkaz-prava-i-obvrski-vo-otkazen-rok-fb8/',                      '/blog/otkaz-prava-i-obvrski-vo-otkazen-rok-fb8', 301);
Route::redirect('/avtorski-dogovori-vo-digitalnata-era-fb7',                       '/blog/avtorski-dogovori-vo-digitalnata-era-fb7', 301);
Route::redirect('/avtorski-dogovori-vo-digitalnata-era-fb7/',                      '/blog/avtorski-dogovori-vo-digitalnata-era-fb7', 301);
Route::redirect('/konkurentska-klauzula-dali-vazi-i-kaj-nas-fb6',                  '/blog/konkurentska-klauzula-dali-vazi-i-kaj-nas-fb6', 301);
Route::redirect('/konkurentska-klauzula-dali-vazi-i-kaj-nas-fb6/',                 '/blog/konkurentska-klauzula-dali-vazi-i-kaj-nas-fb6', 301);
Route::redirect('/godisen-odmor-vo-nasite-zakoni-fb5',                             '/blog/godisen-odmor-vo-nasite-zakoni-fb5', 301);
Route::redirect('/godisen-odmor-vo-nasite-zakoni-fb5/',                            '/blog/godisen-odmor-vo-nasite-zakoni-fb5', 301);
Route::redirect('/danocna-rezidentnost-fb4',                                       '/blog/danocna-rezidentnost-fb4', 301);
Route::redirect('/danocna-rezidentnost-fb4/',                                      '/blog/danocna-rezidentnost-fb4', 301);
Route::redirect('/soveti-za-rabota-od-doma-fb3',                                   '/blog/soveti-za-rabota-od-doma-fb3', 301);
Route::redirect('/soveti-za-rabota-od-doma-fb3/',                                  '/blog/soveti-za-rabota-od-doma-fb3', 301);
Route::redirect('/ramen-vs-progresiven-danok-fb2',                                 '/blog/ramen-vs-progresiven-danok-fb2', 301);
Route::redirect('/ramen-vs-progresiven-danok-fb2/',                                '/blog/ramen-vs-progresiven-danok-fb2', 301);
Route::redirect('/frilenseri-i-danoci-fb1',                                        '/blog/frilenseri-i-danoci-fb1', 301);
Route::redirect('/frilenseri-i-danoci-fb1/',                                       '/blog/frilenseri-i-danoci-fb1', 301);
