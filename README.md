# Laravel Ticket
An Open-Source ticket support system for laravel.

* [Installation](#installation)
* [Creating Ticket](#creating-ticket)
    * [As a User](#creating-ticket-as-user)
    * [As a Guest](#creating-ticket-as-guest)
* [Permissions](#permissions)
    * [Default Permissions](#default-permissions)
        * [Group Permissions](#group-permissions)
        * [Permission Permissions](#permission-permissions)
        * [Statistics Permissions](#statistics-permissions)
        * [Assignment Permissions](#assignment-permissions)
        * [User Permissions](#user-permissions)

## Installation
Project is not ready to fly yet!

---

## Creating Ticket
When a user submits the ticket form or any stuff created a ticket on behalf of someone else, this method can handle these types of requests.

### About Properties & Methods
|Propertie|Description|Data Type|
|---------------|-------------------------------|-------------------|
|<b>Title:</b>  |Title or subject of the ticket.|String             |
|<b>Detail:</b> |Description of user's problem. |Text               |
|<b>Type:</b>   |Type or category of ticket     |String or Integer  |
|<b>Priority</b>|In order of importance 0-5,<br>0:Not critical<br>1:Not Urgent<br>2:Ordinary<br>3:Important<br>4:Urgent<br>5:Critical|Integer|




```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticket = new TicketManager;

    $ticket->title      = "Login Problem";
    $ticket->detail     = "I get an error when i tried to login, need support";
    $ticket->type       = TicketManager::type('accountProblems');
    $ticket->priority   = 1;
```

        