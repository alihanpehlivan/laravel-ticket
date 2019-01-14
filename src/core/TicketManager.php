<?php
namespace Liveth\laravelTicket\core;

use Liveth\laravelTicket\core\RegisterMethod;

class TicketManager extends LaravelTicket{


    public function create() {
        //
        $method = new RegisterMethod('sputnik');
        echo('Incoming:'.$this->title);
        die(print($method->type));
    }

    public function read() {
        //
    }

    public function list(){
        //
    }

    public function update() {
        //
    }

    public function delete() {
        //
    }

    public function hide() {
        //
    }

    public static function type(){
        return 'salata';
    }
}