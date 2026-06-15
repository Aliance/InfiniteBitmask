Infinite bitmask implementation
===

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/aliance/infinite-bitmask.svg)](https://packagist.org/packages/aliance/infinite-bitmask)
![PHP Version](https://img.shields.io/badge/PHP-8.3-green.svg)
[![Code Coverage](https://codecov.io/gh/Aliance/Bitmask/branch/master/graph/badge.svg)](https://codecov.io/gh/Aliance/Bitmask)

About
---

Based on [Aliance/Bitmask](https://github.com/Aliance/Bitmask), but without max bits limitation.

Installation
---

Install the latest version with composer:

```bash
composer require aliance/infinite-bitmask
```

If you checkout this library for testing purposes, install its dependencies:

```bash
docker run --rm -it --volume $PWD:/app -u $(id -u):$(id -g) composer:2 i
```

Usage
---

See usage in [sample](./example/example.php) file.

```bash
docker run -it --rm -v "$PWD":/usr/src/infinite-bitmask -w /usr/src/infinite-bitmask php:8.3-cli php example/example.php 
``` 
``` 
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

For completely tests running just call `composer exec phpunit` or use
```bash
docker run -it --rm -v "$PWD":/usr/src/infinite-bitmask -w /usr/src/infinite-bitmask php:8.3-cli php ./vendor/bin/phpunit
```

License
---

This software is distributed under [MIT license](LICENSE).
