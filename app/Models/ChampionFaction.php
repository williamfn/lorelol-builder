<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChampionFaction extends Model
{
    public static function getChampionsFaction($region)
    {
        $factionRelations = DB::select('
              SELECT cf.champion_id, f.name FROM champion_factions cf
              INNER JOIN factions f ON (cf.faction_id = f.id)
              WHERE f.region = ? ORDER BY f.name', [$region]);

        foreach ($factionRelations as $factionRelation) {
            $sanitizedFactions[$factionRelation->champion_id][] = $factionRelation->name;
        }

        $mapping = array_map(function ($item) {
            return implode(' / ', $item);
        }, $sanitizedFactions);

        return $mapping;
    }

    public static function getFactionByChampion($champId, $region)
    {
        $factions = DB::select('
            SELECT f.id, f.name FROM champion_factions cf
            INNER JOIN factions f ON cf.faction_id = f.id
            WHERE champion_id = ?
            AND f.region = ?', [$champId, $region]);

        foreach ($factions as $faction) {
            $championFactions[] = $faction;
        }

        return $championFactions;
    }
}
