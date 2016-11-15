# GigaFoxWeb Notifier

Thank you for your interest in this product. I hope you will enjoy it. [gigafoxweb.com](http://gigafoxweb.com).

The main task of Notifier is to register system notifications in one place and show them when and where they need.

# Installation
```
composer require gigafoxweb/notifier
```

#Notification
Notifications are GigaFoxWeb\Notifier\Notification class objects or extending it.
```php
$notification = new Notification('message', ['status' => 1]);
```
#Storage
Storage is any extending GigaFoxWeb\Notifier\notification\Storage object.
By default gigafoxweb/notifier have two storages: Memory and Session.
```php
$memoryStorage = new Memory();
$memoryStorage->setNotification($notification);
```
#Handler
Handler is the object what know what to do with filtrated notifications.
```php
$outputHandler = new OutputHandler();
```
#Notifier
Notifier is just the container for GigaFoxWeb\Notifier\notification\Storage and GigaFoxWeb\Notifier\notification\Handler. 
It is singleton pool what can be called everywhere.
```php
Notifier::instance()->setStorage('memory', $memoryStorage);
Notifier::instance()->setHandler('output', $outputHandler);
```
#Filter
Filter used for removing not needle notifications from handling list.
```php
$filter = new RequireParam(['some-required-param', 'another-required-param']);
```
#Filtrator is the pool of Filter objects, used in Handler.
```php
$filtrator = new Filtrator();
$filtrator->addFilter($filter);
Notifier::instance()->getHandler('output')->setFiltrator($filtrator);
```
#Simple application example

```php
require_once __DIR__ . '/vendor/autoload.php';

use GigaFoxWeb\Notifier\Notifier;
use GigaFoxWeb\Notifier\storages\Memory;
use GigaFoxWeb\Notifier\storages\Session;
use GigaFoxWeb\Notifier\Notification;
use GigaFoxWeb\Notifier\handlers\OutputHandler;
use GigaFoxWeb\Notifier\notification\Filtrator;
use GigaFoxWeb\Notifier\notification\filters\RequireParam;

session_start();

//setting notification storages
Notifier::instance()->setStorage('memory', new Memory());
Notifier::instance()->setStorage('session', new Session('GFW_notifications'));

//add notification into memory storage
Notifier::instance()->getStorage('memory')->setNotification(
    'hello',
    new Notification('Hello man!', ['required-param' => 'some-required-value',])
);

if (isset($_POST['some-input'])) {
    $message = ($_POST['some-input'] === 'valid') ? 'Value is valid' : 'Value is not valid';
    //add notification into session storage
    Notifier::instance()->getStorage('session')->setNotification(
        'some-input-validation',
        new Notification($message, ['required-param' => 'some-required-value'])
    );
}

//create filtrator if we want to use only filtrated notifications
$filtrator = (new Filtrator());
$filtrator->addFilter(new RequireParam(['required-param']));

//create notifications handler
$outputHandler = new OutputHandler(__DIR__ . '/notification-layout.php');

//setting notification filtrator to handler
$outputHandler->setFiltrator($filtrator);

//setting handler
Notifier::instance()->setHandler('output', $outputHandler);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- notifications output start -->
    <?= Notifier::instance()->getHandler('output')->processStorage(Notifier::instance()->getStorage('memory')); ?>
    <?= Notifier::instance()->getHandler('output')->processStorage(Notifier::instance()->getStorage('session')); ?>
    <!-- notifications output end -->
    <form action="" method="post">
        <label for="some-input">Some input</label>
        <input type="text" id="some-input" name="some-input">
        <input type="submit">
    </form>
</body>
</html>
```