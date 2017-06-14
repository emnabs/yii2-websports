# Yii2 Websports Component

Provides settings for sporting events, interfaces, custom implementations, pulls, remote interfaces, and data content related to sports competitions. The basic interface implements the definition of soccer data, such as schedule, game, score list, player list.

[![Latest Stable Version](https://poser.pugx.org/emnabs/yii2-websports/v/stable.png)](https://packagist.org/packages/emnabs/yii2-websports)
[![Total Downloads](https://poser.pugx.org/emnabs/yii2-websports/downloads.png)](https://packagist.org/packages/emnabs/yii2-websports)
[![License](https://poser.pugx.org/emnabs/yii2-websports/license.png)](https://packagist.org/packages/emnabs/yii2-websports)


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist emnabs/yii2-websports "*"
```

or add

```json
"emnabs/yii2-websports": "*"
```

to the require section of your composer.json.

## Usage

To use this extension, you have to configure the Connection class in your application configuration:

```php
//configure component:
return [
    //....
    'components' => [
	//....
        'sports' => [
            'class' => 'emhome\websports\Sports',
        ],
	//....
    ]
];
```

Usage example

```php
Yii::$app->sports->compose()->schedule();
```

## 包含接口

* [新浪体育](http://sports.sina.com.cn/)
* [搜达足球](http://www.sodasoccer.com/)


## License

**yii2-websports** is released under the `BSD 3-Clause` License. See the bundled `LICENSE.md` for details.