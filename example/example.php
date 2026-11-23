<?php

declare(strict_types=1);

use Aliance\InfiniteBitmask\InfiniteBitmask;

require __DIR__ . '/../vendor/autoload.php';

enum Permission: int
{
    case Create = 0;
    case Read = 1;
    case Delete = 3;
    case ViewAuditLog = 128;
}

// The stored mask already grants Create in slice 0.
$user = ['permission_slices' => [0 => 1]];
$rights = new InfiniteBitmask($user['permission_slices']);
$rights->setBit(Permission::Read->value);
$rights->setBit(Permission::ViewAuditLog->value);
$user['permission_slices'] = $rights->getMaskSlices();

foreach ($user['permission_slices'] as $index => $mask) {
    echo 'Stored slice ', $index, ': ', $mask, PHP_EOL;
}

$savedRights = new InfiniteBitmask($user['permission_slices']);
foreach (Permission::cases() as $permission) {
    echo $permission->name, ': ', $savedRights->issetBit($permission->value) ? 'yes' : 'no', PHP_EOL;
}
