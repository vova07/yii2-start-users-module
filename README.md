Yii2-Start users module.
========================
This module provide a users managing system for Yii2-Start application.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist vova07/yii2-start-users-module "*"
```

or add

```
"vova07/yii2-start-users-module": "*"
```

to the require section of your `composer.json` file.

Configuration
=============

- Add module to config section:

```
'modules' => [
    'users' => [
        'class' => 'vova07\blogs\Module',
        'robotEmail' => 'no-reply@yii2-start.domain', // Sender email. This email is required. From this address module will send all emails
        'robotName' => 'Robot' // Sender name
    ]
]
```

- Run migrations:

```
php yii migrate --migrationPath=@vova07/users/migrations
```

- Run RBAC command:

```
php yii users/rbac/add
```