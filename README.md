# Composer Alias Plugin

Add alias-support feature for your composer.

[![Build Status](https://img.shields.io/travis/slince/composer-alias/master.svg?style=flat-square)](https://travis-ci.org/slince/composer-alias)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/composer-alias.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/composer-alias)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/composer-alias.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/composer-alias/?branch=master)

## Installation

Install via composer.

```bahs
$ comoposer require slince/composer-alias
```

## Example

Add alias for `composer update`;

```bash
$ composer alias up update
```

Now, you can execute the following command to update your dependencies.

 ```bash
$ composer up
 ```
## USAGE

Add an alias:
```bash
$ composer alias req require
```
Equals:

```bash
$ composer req symfony/console
```
You can use this command to group packages. like this:

```bash
$ composer req-sf "require symfony/console symfony/event-dispatcher"
```

You can install "symfony/console", "symfony/event-dispatcher" with this command:

```bash
$ composer req-sf
```

Execute the following command for help.

```bash
$ composer alias --help
```

## LICENSE

The MIT license. See [MIT](https://opensource.org/licenses/MIT)
 
