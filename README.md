Infinite bitmask implementation
===

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/aliance/infinite-bitmask.svg)](https://packagist.org/packages/aliance/infinite-bitmask)
[![Build Status](https://travis-ci.org/Aliance/InfiniteBitmask.svg?branch=master)](https://travis-ci.org/Aliance/InfiniteBitmask)

Installation
---

For install library you need to modify your composer configuration file

```
    "aliance/infinite-bitmask": "*"
```

And just run installation command

```
    $ composer.phar install
```

Usage
---

See usage in [sample](./example/example.php) file.

```
Aliance/InfiniteBitmask $ php -f example/example.php 
Check user for all flags:
Premium: no
Wizard already shown: no
Paid ever: no
Referral: no
Banned: no
Already notified: no
–––––––––––––––––––––––––––––––––––
Check user for all flags:
Premium: no
Wizard already shown: no
Paid ever: yes
Referral: no
Banned: yes
Already notified: yes
–––––––––––––––––––––––––––––––––––
array(3) {
  [0]=>
  int(8)
  [1]=>
  int(1)
  [2]=>
  int(1)
}
Check user for all flags:
Premium: no
Wizard already shown: no
Paid ever: yes
Referral: no
Banned: yes
Already notified: no
–––––––––––––––––––––––––––––––––––
array(3) {
  [0]=>
  int(8)
  [1]=>
  int(1)
  [2]=>
  int(0)
}
```

Tests
---

For completely tests running just call `phpunit` command from `./vendor/bin`

```
Aliance/InfiniteBitmask $ ./vendor/bin/phpunit 
PHPUnit 4.8.27 by Sebastian Bergmann and contributors.

........................

Time: 100 ms, Memory: 4.00MB

OK (24 tests, 72 assertions)
```
