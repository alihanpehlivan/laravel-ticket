# Laravel Ticket
An Open-Source ticket support system for laravel.

* [Installation](#installation)
* [Creating Ticket](#creating-ticket)
    * [As a User](#creating-ticket-as-user)
    * [As a Guest](#creating-ticket-as-guest)
* [Touching to Tickets](#touching-to-tickets)
    * [Listing Tickets](#listing-tickets)
    * [View Ticket](#viewing-ticket)
    * [Assigning Tickets](#assigning-tickets)
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
You can list tickets with this method, by the default only unsolved tickets will be returning.

#### List Method's Parameters

##### owner
You can list tickets by its owner, the default value is "me", it returns with the tickets assigned the current staff and here are the values of the owner parameter can take;

|Value|Description|Type|
|-----|-----------|----|
|me|It is the default value, it returns the tickets assigned to the current sessions owner.|String|
|all|It returns all the tickets on the system which you have access privileges.|String|
|[id]|It returns all the tickets which the given staff id has, you can do it for the staff which has id=13 is like <b>->list(['owner'=>13])</b>|Integer|
|[ids]|You can specify multiple ids to get their tickets. Like this; <b>list(['owner' => [13, 12, 53, ...]])</b>|Integer Array

```php
<?php

    use Liveth\laravelTicket\core\TicketManager; // Required Class

    $ticketManager = new TicketManager;

    $tickets = $ticketManager->list(['owner' => 'all']);

```
##### paginate
When you got a request to list tickets, server throws 15 tickets per request by default, however you can change this count;

If you want to change paginate count, you can use "paginate" parameter. For example, as you can see, we set our paginate value to 20;
```php
    $ticketManager->list(['paginate' => 50, 'owner' => 'me']);
```
> As you can see, you are able to use multi parameters. The code above will return with the tickets current session has, and 50 tickets per request.

> You can handle pagination just same like [laravel](https://laravel.com/docs/5.7/pagination#displaying-pagination-results)  has.

### Listing by Category

> Listing is in proggess.
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
## Assigning Tickets
You can assign / re-assign tickets to other staffs with this method. 

|Paramater|Description|Type|
|---------|-----------|----|
|to|Target staff id to assign.|Integer|
|ticket|Ticket id to change it's staff|Integer|
|message|Newly assigned staff see this message, messages can be shown staffs only.|String|

For ex;
<i>Staff who his id is 337 wants to re-assign the ticket which it id is 66 to other staff who her id is 48. So the code is below;</i>


```php
<?php
    
    use Liveth\laravelTicket\core\TicketManager;    // Required Class

    $ticket = new TicketManager;

    $ticket->update([
        'assign' => [
            'to'        => 48, 
            'ticket'    => 66,
            'message'   => "I'm on vacation, can you handle with him. Thanks!"
        ]
    ]);
    
```