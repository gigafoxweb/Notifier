# GigaFoxWeb Notifier

Thank you for your interest in this product. I hope you will enjoy it. [gigafoxweb.com](http://gigafoxweb.com).

The main task of Notifier is to register system notifications in one place and show them when and where they need.

# Installation
```
composer require gigafoxweb/notifier
```

If you installed package by composer you just need to :

```php
require_once __DIR__ . '/vendor/autoload.php';
```

else :

```php
require_once '/src/Notifier/Notification.php';
require_once '/src/Notifier/INotifier.php';
require_once '/src/Notifier/Notifier.php';
require_once '/src/Notifier/Helper.php';
require_once '/src/Notifier/SessionNotifier.php';
require_once '/src/Notifier/MemoryNotifier.php';
require_once '/src/Notifier/NotificationFilter.php';
require_once '/src/Notifier/InlineNotificationFilter.php';
require_once '/src/Notifier/NotifierException.php';
require_once '/src/Notifier/SessionNotifierException.php';
```

#Notification
Notifications are GigaFoxWeb\Notifier\Notification class objects or extending it.

#Notifier
Notifiers is static classes extends from GigaFoxWeb\Notifier\Notifier and implements INotifier interface.
It must have 3 required static methods: Notifier::setNotification, Notifier::getNotification, Notifier::removeNotification.
This static classes you will use in your app.
By default package have 2 notifiers MemoryNotifier and SessionNotifier.

You can set notifications to notifier by array || object || callable function || string.
```
MemoryNotifier::setNotification('notification 1 key', new Notification('message'));
MemoryNotifier::setNotification('notification 2 key', 'message');
MemoryNotifier::setNotification('notification 3 key', ['you can do anything you want in this notifier', [
	'show' => true
]]);
MemoryNotifier::setNotification('notification 4 key', function() {
	return new Notification('message');
});
```
#NotificationFilter
NotificationFilters are objects extending GigaFoxWeb\Notifider\NotificationFilter. 
It help you to filtrate notifications when you wanna display/get it from notifier.

NotificationFilters can be created automatically in notifier from callable param || array.

Show all notifications by some search params and filtrate it example:
```
$filters = [
	function(Notification $notification) {
		$notification->setMessage($notification->getMessage() . ' php -v : '. phpversion());
	},
	[
		'function' => function(Notification $notification) {
			$notification->setMessage("<div class='alert alert-{$notification->getParam('class')}'>{$notification->getMessage()}</div>");
		},
		'search' => ['params' => ['class']]
	],
];

MemoryNotifier::showNotificationsBy(['prefix' => 'my', 'params' => [['show', true]]], $filters);
```

#Simple application example :

```
<?php
use GigaFoxWeb\Notifier\MemoryNotifier;
use GigaFoxWeb\Notifier\SessionNotifier;
use GigaFoxWeb\Notifier\Notification;

require_once '/src/Notifier/Notification.php';
require_once '/src/Notifier/INotifier.php';
require_once '/src/Notifier/Notifier.php';
require_once '/src/Notifier/Helper.php';
require_once '/src/Notifier/SessionNotifier.php';
require_once '/src/Notifier/MemoryNotifier.php';
require_once '/src/Notifier/NotificationFilter.php';
require_once '/src/Notifier/InlineNotificationFilter.php';
require_once '/src/Notifier/NotifierException.php';
require_once '/src/Notifier/SessionNotifierException.php';

session_start();

MemoryNotifier::setNotification('my message', ['You can do anything you want in this notifier', [
	'show' => true,
	'class' => 'info'
]]);
MemoryNotifier::setNotification('my message what will not print', ['This message show param is false', [
	'show' => false
]]);

MemoryNotifier::setNotification('not my message', ['it is not my message', [
	'show' => true
]]);

if (isset($_POST['answ'])) {
	$answ = trim(htmlspecialchars($_POST['answ']));
	if (in_array($answ, ['y', 'yes'])) {
		SessionNotifier::setNotification('my message result', ['=)', ['class' => 'success']]);
		SessionNotifier::setNotification('my message result 2', ['it`s great', ['class' => 'success']]);
	} elseif (in_array($answ, ['n', 'no'])) {
		SessionNotifier::setNotification('my message result' , ['=(', ['class' => 'danger']]);
		SessionNotifier::setNotification('my message result 2', ['it`s sad', ['class' => 'success']]);
	} else {
		SessionNotifier::setNotification('my message result' , ['wrong message', ['class' => 'warning']]);
	}
}

$filters = [
	function(Notification $notification) {
		$notification->setMessage($notification->getMessage() . ' php -v : '. phpversion());
	},
	[
		'function' => function(Notification $notification) {
			$notification->setMessage("<div class='alert alert-{$notification->getParam('class')}'>{$notification->getMessage()}</div>");
		},
		'search' => ['params' => ['class']]
	],
];

?>

<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<div class="container-fluid" style="padding-top:20px">
	<div class="row">
		<div class="col-xs-12">
			<section>
				<div class="notifications">
					<?php
					MemoryNotifier::showNotificationsBy(['prefix' => 'my', 'params' => [['show', true]]], $filters);
					SessionNotifier::showNotificationsBy(['prefix' => 'my'], $filters);
					?>
				</div>
				<div class="send">
					<p class="">Is this notifier simple? y/n</p>
					<form class="form-inline" method="post" name="example" action="">
						<label class="" for="answ">answer: </label>
						<input class="form-control" id="answ" type="text" name="answ" value="" />
						<input class="btn btn-default" type="submit"/>
					</form>
				</div>
			</section>
		</div>
	</div>
</div>
</body>
</html>
```