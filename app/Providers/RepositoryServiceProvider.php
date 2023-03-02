<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\LevelRepositoryInterface;
use App\Repositories\LevelRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Interfaces\ExamRepositoryInterface;
use App\Repositories\ExamRepository;
use App\Interfaces\QuizRepositoryInterface;
use App\Repositories\QuizRepository;
use App\Repositories\MangeMockRepository;
use App\Interfaces\ManageMockRepositoryInterface;
use App\Repositories\MockPassageRepository;
use App\Repositories\MockAudioRepository;
use App\Interfaces\MockExerciseRepositoryInterface;
use App\Repositories\MockExerciseRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LevelRepositoryInterface::class, 
            LevelRepository::class
            );
        $this->app->bind(
            CategoryRepositoryInterface::class, 
            CategoryRepository::class
            );
        $this->app->bind(
            ExamRepositoryInterface::class, 
            ExamRepository::class
            );
        $this->app->bind(
            QuizRepositoryInterface::class, 
            QuizRepository::class
            );
        $this->app->bind(
            ManageMockRepositoryInterface::class, 
            MangeMockRepository::class
            );
        $this->app->bind(
            MockExerciseRepositoryInterface::class, 
            MockExerciseRepository::class
            );
        $this->app->bind(
            ExamRepositoryInterface::class, 
            MockPassageRepository::class
            );
        $this->app->bind(
            ExamRepositoryInterface::class, 
            MockAudioRepository::class
            );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
