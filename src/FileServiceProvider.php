<?php

namespace Belca\File;

use Belca\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Belca\File\Contracts\FileRepository;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/translations', 'belca-file');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'belca-file');
        $this->loadRoutesFrom(__DIR__.'/../routes/files.php');

        //\Page::addClass(\Belca\User\Models\RelationshipAuthor::class); // список
        //\Page::addClass(\Belca\User\Models\RelationshipEditor::class); // список
        // Добавление связей с таблицей пользователя, если она установлена

        // TODO синглтоны на репозитории и контракты. Берутся из настроек

        View::composer(
            'edit', 'Belca\File\Http\ViewComposers\EditComposer'
            // Название из настроек, но нужно знать существование или использовать массив, и в случае несуществования ничего не произойдет
            // Класс из настроек или статический. Но по умолчанию может не быть никаких композеров или пустые
        );

    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->recurciveReplaceConfigFrom(
            __DIR__.'/../config/file.php', 'file'
        );

        $this->recurciveReplaceConfigFrom(
            __DIR__.'/../config/file_handler.php', 'file_handler'
        );

        // Добавляем новые компоненты к теме
        $this->recurciveReplaceConfigFrom(
            __DIR__.'/../config/system_theme.php', 'system_theme'
        );

        $this->recurciveReplaceConfigFrom(
            __DIR__.'/../config/controlpanel.php', 'controlpanel'
        );

        // Добавляет новый маршрут
        $this->recurciveReplaceConfigFrom(
            __DIR__.'/../config/routes.php', 'routes'
        );

        $this->app->singleton(FileRepository::class, config('file.repository'));

        // TODO должен возвращать FileHandler, чтобы в него можно было добавлять
        // обработчики, когда они понадобятся.
        // Т.е. его сначала нужно объявить или в качестве синглтона
        // Используется только в системе

        /*
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();

            // Enum
            $loader->alias('PageStatus', config('page.page_status'));
            $loader->alias('PageType', config('page.page_type'));

            // Models
            $loader->alias('Page', config('page.model_page'));

            // Middleware
        });*/

        // TODO DeferrableProvider https://laravel.com/docs/5.8/providers
    }
}
