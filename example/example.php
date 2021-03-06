<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

/*
 * For example, we have big project with users stored in some storage.
 * The main entity for us – users.
 * Users could have the dozens of flags (true/false states). For example:
 * - is premium user;
 * - has wizard already shown;
 * - has paid ever;
 * - is referral user, bought from somewhere;
 * - ... etc ...
 * - is banned;
 * - ... etc ...
 * - has already notified today...
 *
 * We can create dozens of columns with type BOOLEAN for each flags
 * or just one column with array of integers (simple bitmasks).
 */

define('IS_PREMIUM', 0);
define('HAS_WIZARD_ALREADY_SHOWN', 1);
define('HAS_PAID_EVER', 2);
define('IS_REFERRAL', 3);
// ...
define('IS_BANNED', 64); // bitmask number greater than 64*1-1
// ...
define('HAS_ALREADY_NOTIFIED', 128);  // bitmask number greater than 64*2-1

// some users from storage
$user = [
    'bitmasks' => [], // default empty bitmasks
];

// create a Bitmask object, passing user bitmask from storage
$Bitmask = new \Aliance\InfiniteBitmask\InfiniteBitmask($user['bitmasks']);

checkFlags($Bitmask);

// set user some flags
$Bitmask->setBit(HAS_PAID_EVER);
$Bitmask->setBit(IS_BANNED);
$Bitmask->setBit(HAS_ALREADY_NOTIFIED);

checkFlags($Bitmask);

var_dump($Bitmask->getMaskSlices());

// unset daily flag
$Bitmask->unsetBit(HAS_ALREADY_NOTIFIED);

checkFlags($Bitmask);

var_dump($Bitmask->getMaskSlices());

function checkFlags(\Aliance\InfiniteBitmask\InfiniteBitmask $Bitmask)
{
    echo 'Check user for all flags:', PHP_EOL;
    echo 'Premium: ', $Bitmask->issetBit(IS_PREMIUM) ? 'yes' : 'no', PHP_EOL;
    echo 'Wizard already shown: ', $Bitmask->issetBit(HAS_WIZARD_ALREADY_SHOWN) ? 'yes' : 'no', PHP_EOL;
    echo 'Paid ever: ', $Bitmask->issetBit(HAS_PAID_EVER) ? 'yes' : 'no', PHP_EOL;
    echo 'Referral: ', $Bitmask->issetBit(IS_REFERRAL) ? 'yes' : 'no', PHP_EOL;
    echo 'Banned: ', $Bitmask->issetBit(IS_BANNED) ? 'yes' : 'no', PHP_EOL;
    echo 'Already notified: ', $Bitmask->issetBit(HAS_ALREADY_NOTIFIED) ? 'yes' : 'no', PHP_EOL;
    echo str_repeat('–', 35), PHP_EOL;
}
