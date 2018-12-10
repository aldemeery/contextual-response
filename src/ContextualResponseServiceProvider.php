<?php

namespace Aldemeery\ContextualResponse;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ContextualResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Request::macro('wantsXml', function () {
            $acceptable = $this->getAcceptableContentTypes();

            return isset($acceptable[0]) && Str::contains($acceptable[0], ['/xml', '+xml']);
        });

        Request::macro('wantsHtml', function () {
            $acceptable = $this->getAcceptableContentTypes();

            return isset($acceptable[0]) && Str::contains('text/html', $acceptable[0]);
        });

        Request::macro('wantsPdf', function () {
            $acceptable = $this->getAcceptableContentTypes();

            return isset($acceptable[0]) && Str::contains('application/pdf', $acceptable[0]);
        });
    }
}