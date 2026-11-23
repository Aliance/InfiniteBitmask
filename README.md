Infinite bitmask implementation
===

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/aliance/infinite-bitmask.svg)](https://packagist.org/packages/aliance/infinite-bitmask)
![PHP Version](https://img.shields.io/badge/PHP-8.1-green.svg)
[![Code Coverage](https://codecov.io/gh/Aliance/InfiniteBitmask/branch/master/graph/badge.svg)](https://codecov.io/gh/Aliance/InfiniteBitmask)

About
---

Based on [Aliance/Bitmask](https://github.com/Aliance/Bitmask), but without max bits' limitation.

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

```php
use Aliance\InfiniteBitmask\InfiniteBitmask;

$mask = new InfiniteBitmask();
$mask->setBit(2)->setBit(64);

var_dump($mask->issetBit(64));     // bool(true)
var_dump($mask->getMaskSlices());  // [0 => 4, 1 => 1]
```

The [permission example](./example/example.php) uses an integer-backed enum for bit positions.
A user already has Create permission. Granting Read sets another bit in slice 0.
Granting ViewAuditLog (bit 128) creates slice 2. When saving the array returned by
`getMaskSlices()`, keep its numeric keys so the constructor can restore the permissions.
Each key is a slice index and each value is a signed 64-bit mask. Bit 63 sets the
sign bit of slice 0. Unsetting the last bit in an existing slice leaves its value
at zero. Slices that were never set can be absent.

```bash
docker run --rm -v "$PWD":/usr/src/infinite-bitmask -w /usr/src/infinite-bitmask php:8.3-cli php example/example.php
```

```text
Stored slice 0: 3
Stored slice 2: 1
Create: yes
Read: yes
Delete: no
ViewAuditLog: yes
```

Tests
---

For complete tests running just call `composer exec phpunit` or use
```bash
docker run -it --rm -v "$PWD":/usr/src/infinite-bitmask -w /usr/src/infinite-bitmask php:8.3-cli php ./vendor/bin/phpunit
```

Upgrading stored masks
---

Earlier releases could round the slice index for bit positions above `2^53`.
For example, setting `PHP_INT_MAX` could also make `PHP_INT_MAX - 64` appear set.
If you used positions in this range, rebuild the affected masks from the original
bit positions before loading them with this version. When positions collided, the
stored mask alone cannot identify which flags were originally set.

License
---

This software is distributed under [MIT license](LICENSE).
