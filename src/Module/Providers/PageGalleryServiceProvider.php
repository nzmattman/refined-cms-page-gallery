<?php

namespace RefinedDigital\PageGallery\Module\Providers;

use Illuminate\Support\ServiceProvider;
use RefinedDigital\CMS\Modules\Pages\Aggregates\PageAggregate;

class PageGalleryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../config/page-gallery.php' => config_path('page-gallery.php'),
        ], 'page-gallery');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../../../config/page-gallery.php', 'page-gallery');

        $fields = [
            [ 'name' => 'Image', 'page_content_type_id' => 4, 'field' => 'image', 'hide_label' => true ]
        ];

        if (config('page-gallery.extra_fields')) {
            $fields = array_merge($fields, config('page-gallery.extra_fields'));
        }

        app(PageAggregate::class)
            ->addModule('Gallery', [
                'tab' => 'gallery',
                'type' => 'repeatable',
                'config' => 'page-gallery',
                'fields' => $fields
            ]);
    }
}
