<?php

namespace App\HelpDesk\Providers;

use App\HelpDesk\Models\Comment;
use App\HelpDesk\Models\Status;
use App\HelpDesk\Models\Ticket;
use App\HelpDesk\Models\Priority;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\HelpDesk\Models\Category;

class HelpDeskServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->defineTableNames();
        $this->mergeConfigFrom(dirname(__DIR__, 1).'/config.php', 'helpDesk');
        $this->defineModelRelations();
        $this->defineBluePrintMacros();
    }
    
    public function boot()
    {
        $this->loadMigrationsFrom(dirname(__DIR__, 1).'/Database/Migrations');
        
        $this->loadTranslationsFrom(dirname(__DIR__, 1).'/Translations', 'helpDesk');
        
        $this->publishes([
            dirname(__DIR__, 1).'/Translations' => resource_path('lang/vendor/helpDesk'),
        ]);
        
        $this->publishes([
            dirname(__DIR__, 1).'/config.php' => config_path('helpDesk.php'),
        ], 'config');
        
        $this->loadViewsFrom(dirname(__DIR__, 1).'/Views', 'helpDesk');
        
        $this->loadRoutesFrom(dirname(__DIR__, 1).'/Route/web.php');
        $this->loadRoutesFrom(dirname(__DIR__, 1).'/Route/api.php');
        
        $this->modelBinding();
    }
    
    protected function modelBinding()
    {
        Route::bind('t', function ($value) {
            $key = 'ticket:'.$value;
            
            return Cache::remember($key, config('constants.CACHE_60'), function () use ($value) {
                return Ticket::where('id', $value)->first() ?: abort(404);
            });
        });
    }

    private function defineModelRelations()
    {
        Ticket::belongs_to('status', Status::class);
        Status::has_many('tickets', Ticket::class);

        Ticket::belongs_to('tickets', Category::class);
        Category::has_many('category', Ticket::class);

        Ticket::belongs_to('priority', Priority::class);
        Priority::has_many('tickets', Ticket::class);

        Ticket::has_many('comments', Comment::class);
        Comment::belongs_to('ticket', Ticket::class);


        User::has_many('tickets', Ticket::class);
        Ticket::belongs_to('user', User::class, 'user_id');

        User::has_many('agentTickets', Ticket::class);
        Ticket::belongs_to('agent', User::class, 'agent_id');

        Category::hasManyToMany(['users', User::class], 'help_categories_users', 'category_id', 'user_id');
        User::hasManyToMany(['helpCategories', Category::class], 'help_categories_users', 'user_id', 'category_id');
    }

    private function defineBluePrintMacros(): void
    {
        Blueprint::macro('addForeignColumn', function ($colName, $table) {
            $this->integer($colName)->unsigned();
            $this->foreign($colName)->references('id')->on($table)->onDelete('cascade')->onUpdate('cascade');
        });
    }

    private function defineTableNames()
    {
        if(!defined('help_tickets')) {
            define('tickets_table', 'help_tickets');
        }
    }
}
