<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use App\Interfaces\MateriaRepositoryInterface;
use App\Repositories\MateriaRepository;
use App\Interfaces\PeriodoRepositoryInterface;
use App\Repositories\PeriodoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioRepositoryInterface::class,UsuarioRepository::class);
        $this->app->bind(MateriaRepositoryInterface::class, MateriaRepository::class);
        $this->app->bind(PeriodoRepositoryInterface::class, PeriodoRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
