<?php

/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/general.php
 */

return array(
    'appId' => 'cccomus',
    'cpTrigger' => 'cccomus',
    'devMode' => true,
    'useCompressedJs' => false,
    'cacheDuration' => 'P1W',
    'cacheMethod' => 'redis',
    'defaultCookieDomain' => '.creditcards.com',
    'phpMaxMemoryLimit' => '1024M',
    'phpSessionName' => 'CCCOMUSSESSID',
    'sendPoweredByHeader' => false,
    'timezone' => 'America/Chicago',
    'slugWordSeparator' => '-',
    'postCpLoginRedirect' => 'dashboard',
    'userSessionDuration' => false,
    'extraAllowedFileExtensions' => 'css, js, less, scss, sass',
);
