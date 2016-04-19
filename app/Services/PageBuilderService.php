<?php namespace App\Services;

use App\Models\Champion;
use App\Models\ChampionFaction;
use App\Models\ChampionRelation;
use Illuminate\Support\Facades\Lang;
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
                'link' => '/champion/'.strtolower($relation->champion_key),
                'url' => config('riot.image.portrait').$relation->champion_key.'.png',
                'name' => $relation->champion_key,
            ];
            $champion[$relation->relation_type][] = $relationData;
        }

        $champion['factions'] = ChampionFaction::getFactionByChampion($champion['id'], $region);

        $champion['portrait'] = config('riot.image.portrait').$champion['key'].'.png';
        $champion['splash'] = config('riot.image.splash').$champion['key'].'_0.jpg';

        $champion['region'] = $region;

        return Twig::render(
            'champion/template',
            ['champion' => $champion, 'regions' => Lang::get('system.language_names')]
        );
    }

    public function createChampionPages($region)
    {
        ob_implicit_flush(true);
        ob_end_flush();

        $pagesDirectory = storage_path('pages/'.config('riot.version.actual_patch').'/'.$region);
        if (!file_exists($pagesDirectory)) {
            mkdir($pagesDirectory, 0775, true);
        }

        echo 'Getting all champ\'s data...<br/>';
        $champions = Champion::where(
            ['region' => $region, 'version' => config('riot.version.actual_patch')]
        )->get()->toArray();

        foreach ($champions as $champion) {
            echo 'Processing '.$champion['name'].'...';
            $relations = ChampionRelation::where('champion_id', $champion['id'])->orderBy('champion_key')->get();

            foreach ($relations as $relation) {
                $relationData = [
                    'link' => '/champion/'.strtolower($relation->champion_key),
                    'url' => config('riot.image.portrait').$relation->champion_key.'.png',
                    'name' => $relation->champion_key,
                ];
                $champion[$relation->relation_type][] = $relationData;
            }

            $champion['factions'] = ChampionFaction::getFactionByChampion($champion['id'], $region);

            $champion['portrait'] = config('riot.image.portrait').$champion['key'].'.png';
            $champion['splash'] = config('riot.image.splash').$champion['key'].'_0.jpg';

            $champion['region'] = $region;

            echo 'Creating champion HTML file...<br/>';
            $page = Twig::render(
                'champion/template',
                ['champion' => $champion, 'regions' => Lang::get('system.language_names')]
            );
            $file = fopen($pagesDirectory.'/'.strtolower($champion['key']).'.html', 'w+');
            fwrite($file, $page);
            fclose($file);
        }

        echo 'Finished processing '.count($champions).' champions';
    }

    public function createHomePages($region)
    {
        $homeDirectory = storage_path('pages/'.config('riot.version.actual_patch').'/'.$region);
        if (!file_exists($homeDirectory)) {
            mkdir($homeDirectory, 0775, true);
        }

        $page = Twig::render('home/template', ['region' => $region, 'regions' => Lang::get('system.language_names')]);
        $file = fopen($homeDirectory.'/home.html', 'w+');
        fwrite($file, $page);
        fclose($file);

        echo 'Finished processing home page for language: '.$region;
    }
}
