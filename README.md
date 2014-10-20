Yii2 TurboSMS
=============

[TurboSMS component](http://kop.github.io/yii2-turbosms) gives you an ability to send SMS messages via TurboSMS.ua SMS gateway.

This component is built with use of [TurboSMS SOAP service](http://turbosms.ua/soap.html).

[![Latest Stable Version](https://poser.pugx.org/kop/yii2-turbosms/v/stable.svg)](https://packagist.org/packages/kop/yii2-turbosms)
[![Code Climate](https://codeclimate.com/github/kop/yii2-turbosms.png)](https://codeclimate.com/github/kop/yii2-turbosms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kop/yii2-turbosms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kop/yii2-turbosms/?branch=master)
[![Version Eye](https://www.versioneye.com/php/kop:yii2-turbosms/badge.svg)](https://www.versioneye.com/php/kop:yii2-turbosms)
[![License](https://poser.pugx.org/kop/yii2-turbosms/license.svg)](https://packagist.org/packages/kop/yii2-turbosms)

## Requirements

- Yii 2.0
- PHP 5.4
- PHP extension `SOAP`


## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

``` php composer.phar require kop/yii2-turbosms "dev-master" ```

or add

``` "kop/yii2-turbosms": "dev-master"```

to the `require` section of your `composer.json` file.


## Setup

All you need is to declare a new component in your application configuration file like follows:

```php
return [
    ...
    'components' => [
        ...
        'sms' => [
            'class' => '\kop\y2ts\TurboSMS',
            'username' => '<<< YOUR USERNAME HERE >>>'
            'password' => '<<< YOUR PASSWORD HERE >>>',
            'alphaName' => 'MyWebsite',
        ]
        ...
    ]
    ...
];
```


## Configuration

#### `username`

The username used for authentication on TurboSMS SOAP service.

#### `password`

The password used for authentication on TurboSMS SOAP service.

#### `alphaName`

The name that users will see as the message sender name.

## Usage

As simple as:

```php
Yii::$app->sms->send(['+380501234567', '+380502345678'], 'Hello world!');
```

Please refer to the class documentation for more methods and options.

## Report

- Report any issues [on the GitHub](https://github.com/kop/yii2-scroll-pager/issues).


## License

**yii2-turbosms** is released under the MIT License. See the bundled `LICENSE.md` for details.


## Resources

- [Project Page](http://kop.github.io/yii2-turbosms)
- [Packagist Package](https://packagist.org/packages/kop/yii2-turbosms)
- [Source Code](https://github.com/kop/yii2-turbosms)