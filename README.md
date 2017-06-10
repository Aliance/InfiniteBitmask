Infinite bitmask implementation
===

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/aliance/infinite-bitmask.svg)](https://packagist.org/packages/aliance/infinite-bitmask)
[![Build Status](https://travis-ci.org/Aliance/InfiniteBitmask.svg?branch=master)](https://travis-ci.org/Aliance/InfiniteBitmask)
[![Code Coverage](https://scrutinizer-ci.com/g/Aliance/InfiniteBitmask/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Aliance/InfiniteBitmask/?branch=master)

About
---

Currently supported PHP version: >= 5.5

Installation
---

Install the latest version with composer:

```bash
$ composer require aliance/infinite-bitmask
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

For completely tests running just call `composer exec phpunit`

License
---

This software is distributed under [MIT license](LICENSE).
