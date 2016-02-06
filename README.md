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
require_once __DIR__ . '/src/Notifier/INotifier.php';
require_once __DIR__ . '/src/Notifier/Notifier.php';
require_once __DIR__ . '/src/Notifier/SessionNotifier.php';
require_once __DIR__ . '/src/Notifier/MemoryNotifier.php';
require_once __DIR__ . '/src/Notifier/NotifierException.php';
require_once __DIR__ . '/src/Notifier/SessionException.php';
require_once __DIR__ . '/src/Notifier/NotificationFilter.php';
```

simple application example :

```php
session_start();

try {

    \GigaFoxWeb\MemoryNotifier::set('interesting message', 'you can do anything you want in this notifier', ['status' => 'inform']);

    if (isset($_POST['answ'])) {
        $answ = trim(htmlspecialchars($_POST['answ']));
        if (in_array($answ, ['y', 'yes'])) {
            \GigaFoxWeb\SessionNotifier::set('result' , '=)', ['status' => 'success']);
        } elseif (in_array($answ, ['n', 'no'])) {
            \GigaFoxWeb\SessionNotifier::set('result' , '=(', ['status' => 'error']);
        } else {
            \GigaFoxWeb\SessionNotifier::set('result' , 'wrong message', ['status' => 'error']);
        }
    }

    $filtrator = new \GigaFoxWeb\NotificationFilter();
    $filtrator->add(function($n , $p) {
        // $p -  notification parameters (array)
        return "<div class='success notification'>{$n}</div>";
    }, ['status' => 'success']);
    $filtrator->add(function($n) {
        return "<div class='error notification'>{$n}</div>";
    }, ['status' => 'error'])->add(function($n) {
        return "<div class='inform notification'>{$n}</div>";
    }, ['status' => 'inform']);

    \GigaFoxWeb\SessionNotifier::showAll($filtrator);
    \GigaFoxWeb\MemoryNotifier::showAll($filtrator);

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