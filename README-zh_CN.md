# Composer 别名插件

给你的 Composer 添加别名支持功能。

[![Build Status](https://img.shields.io/travis/slince/composer-alias/master.svg?style=flat-square)](https://travis-ci.org/slince/composer-alias)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/composer-alias.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/composer-alias)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/composer-alias.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/composer-alias/?branch=master)

## 安装

使用 composer 安装.

```bahs
$ composer global require slince/composer-alias
```

## 案例

给 `composer update` 添加别名;

```bash
$ composer alias up update
```

现在你可以使用这样的命令去更新你的依赖。

 ```bash
$ composer up
 ```
## 用法

### 添加别名:
```bash
$ composer alias req require
```
等价于:

```bash
$ composer req symfony/console
```

### 给 packages 分组

你可以像这样，给你常用的第三方包进行分组
```bash
$ composer req-sf "require symfony/console symfony/event-dispatcher"
```

现在你可以使用像这样的比较短的命令同事安装多个包 "symfony/console", "symfony/event-dispatcher"

```bash
$ composer req-sf
```
### 列出所有的别名

```bash
$ composer alias -l
```

会输出：

```
 -------- --------------------------------------------------
  Alias    Command
 -------- --------------------------------------------------
  val      validate
  up       update
  req-sf   require symfony/event-dispatcher symfony/console
  req      require
  i        install
 -------- --------------------------------------------------
```
### 移除已经存在的别名

```bash
$ composer alias [alias name] --unset
```

### Help

执行下面命令查看帮助

```bash
$ composer alias --help
```

## 开源协议

采用 MIT 协议. 看 [MIT](https://opensource.org/licenses/MIT)
 
