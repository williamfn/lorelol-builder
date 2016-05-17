<?php

$actualPatch = '6.9.1';
$cdnVersion = '1.1.9';
$apiStaticDataVersion = 'v1.2';

return [
    'api' => [
        'base_url' => 'https://global.api.pvp.net',
    ],
    'image' => [
        'background' => "http://cdn.leagueoflegends.com/game-info/$cdnVersion/images/champion/backdrop/bg-",
        'portrait'   => "http://ddragon.leagueoflegends.com/cdn/$actualPatch/img/champion/",
        'splash'     => "http://ddragon.leagueoflegends.com/cdn/img/champion/splash/",
    ],
    'version' => [
        'actual_patch' => $actualPatch,
        'cdn_version' => $cdnVersion,
        'api_static_data_version' => $apiStaticDataVersion,
    ],
    'lang' => [
        'na' => ['region' => 'na', 'locale' => 'en_US'],
        'br' => ['region' => 'br', 'locale' => 'pt_BR'],
        'de' => ['region' => 'euw', 'locale' => 'de_DE'],
    ],
];
