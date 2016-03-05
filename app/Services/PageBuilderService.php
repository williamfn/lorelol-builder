<?php namespace App\Services;

use App\Models\Champion;
use App\Models\ChampionFaction;
use App\Models\ChampionRelation;
use TwigBridge\Facade\Twig;

class PageBuilderService
{
    public function showTemplate($champId, $region)
    {
        $champion = Champion::where(
            ['id' => $champId, 'region' => $region, 'version' => config('riot.version.actual_patch')]
        )->first()->toArray();

        $relations = ChampionRelation::where('champion_id', $champion['id'])->orderBy('champion_key')->get();

        foreach ($relations as $relation) {
            $relationData = [
                'link' => '/template/'.$relation->relation_id.'/'.$region,
                'url' => config('riot.image.portrait').$relation->champion_key.'.png',
                'name' => $relation->champion_key,
            ];
            $champion[$relation->relation_type][] = $relationData;
        }

        $champion['factions'] = ChampionFaction::getFactionByChampion($champion['id'], $region);

        $champion['portrait'] = config('riot.image.portrait').$champion['key'].'.png';
        $champion['splash'] = config('riot.image.splash').$champion['key'].'_0.jpg';

        $champion['region'] = $region;

        return Twig::render('champion/template', ['champion' => $champion]);
    }

    public function createChampionPages($region)
    {
        // Source temporário para testes
        $data = json_decode(file_get_contents(storage_path('zyra.json')), true);

        $pagesDirectory = storage_path('pages/'.config('riot.version.actual_patch'));

        if (!file_exists($pagesDirectory)) {
            mkdir($pagesDirectory, 0777, true);
        }

        foreach ($data as $champion) {
            $page = Twig::render('champion_template', ['champion' => $champion]);

            $file = fopen($pagesDirectory.'/'.strtolower($champion['id']).'.html', 'w+');
            fwrite($file, $page);
            fclose($file);
        }
    }
}
