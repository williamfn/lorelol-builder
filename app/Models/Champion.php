<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'title', 'faction', 'key', 'lore', 'region', 'version'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
