# GigaFoxWeb Notifier

Thank you for your interest in this product. We hope you will enjoy it. [gigafoxweb.com](http://gigafoxweb.com).

The main task of this project is to help you manage system notification in your application.
The normal API i will write in future. Before that you can see a simple example.

#### You can install it by composer

```
composer require gigafoxweb/notifier
```

# Usage example

If you installed package by composer you just need to :

```php
require_once __DIR__ . '/vendor/autoload.php';
```

else :

```php
require_once 'src/Notifier/INotifier.php';
require_once 'src/Notifier/Notification.php';
require_once 'src/Notifier/Notifier.php';
require_once 'src/Notifier/Helper.php';
require_once 'src/Notifier/SessionNotifier.php';
require_once 'src/Notifier/MemoryNotifier.php';
require_once 'src/Notifier/NotifierException.php';
require_once 'src/Notifier/SessionNotifierException.php';
require_once 'src/Notifier/NotificationFiltrator.php';
```

simple application example :

```php
session_start();

try {

    \GigaFoxWeb\Notifier\MemoryNotifier::set('interesting message',
        'you can do anything you want in this notifier',
        ['status' => 'inform', 'show' => true, 'fun' => true]
    );
    \GigaFoxWeb\Notifier\MemoryNotifier::set('bad key',
        'bad message',
        ['status' => 'inform', 'show' => true, 'fun' => true]
    );
    \GigaFoxWeb\Notifier\MemoryNotifier::set('interesting message 2',
        'this message will not display cose "show" param = false',
        ['status' => 'inform', 'show' => false]
    );
    \GigaFoxWeb\Notifier\MemoryNotifier::set('NOT interesting message',
        'this message will not display too cose it do not have "interesting" prefix',
        ['status' => 'inform', 'show' => true]
    );
    \GigaFoxWeb\Notifier\MemoryNotifier::set('interesting message 3',
        'this message will not display too cose it do not have "fun" param',
        ['status' => 'inform', 'show' => true]
    );

    if (isset($_POST['answ'])) {
        $answ = trim(htmlspecialchars($_POST['answ']));
        if (in_array($answ, ['y', 'yes'])) {
            \GigaFoxWeb\Notifier\SessionNotifier::set('result' , '=)', ['status' => 'success']);
        } elseif (in_array($answ, ['n', 'no'])) {
            \GigaFoxWeb\Notifier\SessionNotifier::set('result' , '=(', ['status' => 'error']);
        } else {
            \GigaFoxWeb\Notifier\SessionNotifier::set('result' , 'wrong message', ['status' => 'error']);
        }
    }

    $filtrator = new \GigaFoxWeb\Notifier\NotificationFiltrator();
    $filtrator->add(function(\GigaFoxWeb\Notifier\Notification $notification) {
        $notification->value = "<div class='success notification'>{$notification->value}</div>";
        return $notification;
        //second param: example search notification which needs filter. ['params' => ... , 'function' => ...]
    }, ['params' => [['status', 'success']]]);

    $filtrator->add(function(\GigaFoxWeb\Notifier\Notification $notification) {
        $notification->value = "<div class='error notification'>{$notification->value}</div>";
        return $notification;
    }, ['params' => [['status', 'error']]]);

    $filtrator->add(function(\GigaFoxWeb\Notifier\Notification $notification) {
        $notification->value = "<div class='inform notification'>{$notification->value}</div>";
        return $notification;
    }, ['params' => [['status', 'inform']]]);

    \GigaFoxWeb\Notifier\SessionNotifier::showAll($filtrator);
    \GigaFoxWeb\Notifier\MemoryNotifier::showAll($filtrator, [
        // example notification search by
        'keys' => ['interesting message', 'interesting message 2', 'NOT interesting message', 'interesting message 3'],
        'prefix' => 'interesting',
        'params' => [
            ['show', true]
        ],
        'function' => function(\GigaFoxWeb\Notifier\Notification $notification) {
            if (isset($notification->params['fun']) && $notification->params['fun']) {
                return true;
            }
            return false;
        }
    ]);

} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .error {
            border-left:3px solid red;
        }
        .success {
            border-left:3px solid green;
        }
        .inform {
            border-left:3px solid orange;
        }
        .notification {
            padding:10px;
            background-color: whitesmoke;
            box-shadow:3px 3px 3px rgba(0,0,0,0.5);
            margin: 20px 0;
        }
    </style>
</head>
<body>
<p>Is it true? y/n</p>
<form method="post" name="example" action="">
    <input type="text" name="answ" value=""/>
    <input type="submit"/>
</form>
</body>
</html>
```