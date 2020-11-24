<?php

Route::domain(config('zenlease.server_url'))->group(function () {
    Route :: get('/register', '\App\Http\Controllers\PageController@register') -> name('register');
    Route::get('/', 'WelcomeController@show')->name('landing_page');
    Route::get('/home', 'HomeController@show')->name('home');
    /*Blog related routes*/
    Route::get('/blog', 'PageController@blog')->name('articles');
    Route::get('/author/{slug}', 'PageController@findPostByAuthor')->name('blog.author');
    Route::get('/articles/{slug}', 'PageController@findPostBySlug')->name('blog.post');
    Route::get('/page/{slug}', 'PageController@findPageBySlug');
    Route::get('/blog/search/', 'PageController@searchBlogByTitle')->name('blog.search');
    Route::view('/pricing', 'website.views.pages.pricing')->name('blog.pricing');
    Route::get('/fresh', 'PageController@updateIndexedArticles')->name('index.json');
    Route :: post('/register', 'Auth\RegisterController@createCompany');
    Route::get('/blog-search', 'PageController@searchBlogByTitle');
    // Webhooks...
    Route :: post('/webhook/stripe', 'System\WebhookController@handleWebhook');
    Route :: post('/register/rules', 'HomeController@initialRegistration');

});

Route::domain('app.' . config('zenlease.server_url'))->group(function () {
    Route::get('/login/initial', 'HomeController@loginInitial')->name('login_initial');
    Route::post('/login/initial', 'HomeController@postLoginInitial');
    Route ::get('/sso/jwt/login', '\App\Http\Controllers\System\FreshDeskController@sso');
});


