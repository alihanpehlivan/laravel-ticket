# Laravel Ticket
An Open-Source ticket support system for laravel.

* [Installation](#installation)
* [Creating Ticket](#creating-ticket)
    * [As a User](#creating-ticket-as-user)
    * [As a Guest](#creating-ticket-as-guest)
* [Touching to Tickets](#touching-to-tickets)
    * [Listing Tickets](#listing-tickets)
    * [View Ticket](#viewing-ticket)
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
|<b>Title   :</b>  |Title or subject of the ticket.|String             |
|<b>Detail  :</b> |Description of user's problem. |Text               |
|<b>Type    :</b>   |Type or category of ticket, you can use title or id of the type. |String or Integer  |
|<b>Priority</b>|<i>In order of importance 0-5,</i><br>0 : Not critical<br>1 : Not Urgent<br>2 : Ordinary<br>3 : Important<br>4 : Urgent<br>5 : Critical|Integer|


You can create a new ticket using <b>create</b> method, before calling the create function, title, detail, type and priority properties must be given!

#### Creating Ticket as User
```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticket = new TicketManager;

    $ticket->title      = "Login Problem";
    $ticket->detail     = "I get an error when i tried to login, need support";
    $ticket->type       = TicketManager::type('accountProblems');
    $ticket->priority   = 1;

    $ticket->create();
```
> TicketManager::type() method returns with object of type which is given as parameter. Return object includes those parameters; id of object, title of object.

When the user submits a new support ticket, if a user is logged in to the system alias if Auth::check() returns true; ticket owner automaticly setted as current session owner. But if the user is not logged in so Auth::check() returns with false; the system will create a guest account automatically. And the ticket owner will be this account.

#### Creating Ticket as Guest
This code below is for guest's ticket creation. Extra required inputs stated as comment.
```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticket = new TicketManager;

    $ticket->title          = "Login Problem";
    $ticket->detail         = "I get an error when i tried to login, need support";
    $ticket->type           = TicketManager::type('accountProblems');
    $ticket->priority       = 1;
    $ticket->name           = "Ahmet";                      // This is extra input
    $ticket->surname        = "Çelikezer";                  // This is extra input
    $ticket->email          = "ahmetcelikezer@icloud.com";  // This is extra input

    $ticket->create();
```

> If the user has not auth session on system alias user not logged in. The create method must have name, surname and email properties!

---
## Listing Tickets

### Listing All
You can list tickets with this method.

#### List Method's Parameters

##### owner
You can list tickets by its owner, the default value is "me", it returns with the tickets assigned the current staff and here are the values of the owner parameter can take;
|Value|Description|Type|
|-----|-----------|----|
|me|It is the default value, it returns the tickets assigned to the current sessions owner.|String|
|all|It returns all the tickets on the system which you have access privileges.|String|
|[id]|It returns all the tickets which the given staff id has, you can do it for the staff which has id=13 is like <b>->list(['owner'=>13])</b>|Integer|

```php
<?php

    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticketManager = new TicketManager;

    $tickets = $ticketManager->list(['owner' => 'all']);

```
If you want to change paginate count, you can use "paginate" parameter. For example, as you can see, we set our paginate value to 20;
```php
    $ticketManager->list(['paginate' => 20, 'owner' => 'all']);
```

### Listing by Category

---

## Touching to Tickets

### Viewing Ticket
To view the requested ticket is as simple as making the flick. How simple, this simple;

```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticket = new TicketManager;

    $ticket->id = 5;                            // Requested ticket id
    $flick = $ticket->read();
```
So <b>read</b> method returns this JSON object
```js
        {
            'error'       : false,
            'errors'      : [],
            'title'       : "Ticket Subject",
            'detail'      : "This is the long text for my problem",
            'type'        : {'id' : 2, 'title' : 'login_problem', 'text' : 'Login Problem'},
            'owner'       : {
                'login'     : true, 
                'id'        : 775, 
                'name'      : 'Ahmet',
                'surname'   : 'Çelikezer',
                'email'     : 'ahmetcelikezer@icloud.com'
                },
            'date'        : {'created_at' : '2019-01-14 17:57:16', 'updated_at' : '2019-01-15 13:00:38'},
            'externals'   : {'user_defined_variable' : 'user_defined_value', ...}
        }
```
> When any staff viewed and ticket, this will be recorded as "XXX is readed this ticket", if you have a permission. You can view ticket anonymously.

#### To view Ticket Anonymously
Just add array value with 'anonymous' with true. For Ex:
```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager;    // Required Class

    $ticket = new TicketManager;

    $ticket->id = 5;                                // Requested ticket id
    $flick = $ticket->read(['anonymous' => true]);  // Read as anonymous
    // Return is same
```
