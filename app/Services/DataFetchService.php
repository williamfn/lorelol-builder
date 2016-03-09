<?php namespace App\Services;

use App\Models\Champion;
use App\Models\ChampionFaction;
use GuzzleHttp\Client;

class DataFetchService
{
    public function populateAllChampionsNewVersion($region)
    {
        ob_implicit_flush(true);
        ob_end_flush();

        echo 'Getting all champ\'s faction...<br/>';
        $factionMap = ChampionFaction::getChampionsFaction($region);

        echo 'Getting all champ\'s data...<br/>';
        $champions = $this->getAllChampionsData($region, 'lore');

        foreach ($champions['data'] as $champion) {
            $champion['region'] = $region;
            $champion['version'] = config('riot.version.actual_patch');
            $champion['faction'] = $factionMap[$champion['id']];

            echo 'Processing '.$champion['name'].'...<br/>';
            Champion::create($champion);

            $championJson = ['label' => $champion['name'], 'value' => strtolower($champion['key'])];
            $toJsonFile[] = $championJson;
        }

        echo 'Creating all champions JSON file...<br/>';
        $this->createChampionJSONFile($toJsonFile, $region);

        echo 'Finished processing '.count($champions['data']).' champions';
    }

    private function getAllChampionsData($regionAlias, $data = 'lore')
    {
        $region = config('riot.lang.'.$regionAlias.'.region');
        $locale = config('riot.lang.'.$regionAlias.'.locale');

        $staticDataVersion = config('riot.version.api_static_data_version');
        $entrypoint = config('riot.api.base_url')."/api/lol/static-data/$region/$staticDataVersion/champion";

        $client = new Client();
        $response = $client->request('GET', $entrypoint, [
            'query' => [
                'api_key' => env('RIOT_API_KEY'),
                'champData' => $data,
                'dataById' => true,
                'locale' => $locale,
                'version' => config('riot.version.actual_patch'),
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        sort($data['data']);

        return $data;
    }

    private function createChampionJSONFile($championData, $region)
    {
        // Order by champion name
        sort($championData);

        $jsonFilepath = public_path('/json/champions-'.$region.'.json');

        $file = fopen($jsonFilepath, 'w');
        fwrite($file, json_encode($championData));

        fclose($file);
    }

    private function getChampionData($regionAlias, $id, $data = 'lore')
    {
        $region = config('riot.lang.'.$regionAlias.'.region');
        $locale = config('riot.lang.'.$regionAlias.'.locale');

        $staticDataVersion = config('riot.version.api_static_data_version');
        $entrypoint = config('riot.api.base_url')."/api/lol/static-data/$region/$staticDataVersion/champion/$id";

        $client = new Client();
        $response = $client->request('GET', $entrypoint, [
            'query' => [
                'api_key' => env('RIOT_API_KEY'),
                'champData' => $data,
                'dataById' => true,
                'locale' => $locale,
                'version' => config('riot.version.actual_patch'),
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function readSpecialEvents($region)
    {
        $filePath = storage_path('special_events_'.$region.'.json');
        $file = fopen($filePath, 'r');
        $events = fgets($file);

        exit(var_dump(json_decode($events)));
    }
}
