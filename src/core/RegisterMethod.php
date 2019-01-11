<?php
namespace Liveth\laravelTicket\core;

use Illuminate\Support\Facades\Auth;

class RegisterMethod {

    public $type;

    /**
     * Returns ticket type, and required inputs.
     * 
     */
    public function __construct($params) {

        Auth::check() ? $this->type = 'member' : $this->type = 'guest';

        return $this->type;
    }
}