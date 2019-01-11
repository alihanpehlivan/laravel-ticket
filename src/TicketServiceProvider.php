<?php
/*
 * Laravel Ticket Project
 * An Open-Source ticket support system for laravel.
 * License : MIT
 * Authors : Alihan Pehlivan - alihan.pehlivan@students.plymouth.ac.uk / Ahmet Celikezer touch@ahmetcelikezer.com
 * Version : 0.0.1
 */
namespace Liveth\laravelTicket;

use Carbon\Laravel\ServiceProvider;


class TicketServiceProvider extends ServiceProvider {
     
    public function boot() {
        
        // Migrations Caller
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register() {
        //
    }
}