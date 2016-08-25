<?php

namespace Inoplate\Abilities;

use DB;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Abilities of role
     * 
     * @var array
     */
    protected $abilities = [];

    /**
     * Determine abilites was fetched from database
     * 
     * @var boolean
     */
    protected $abilityFetched = false;

    /**
     * Get role abilities.
     *
     * @return string
     */
    public function getAbilitiesAttribute()
    {
        if($this->abilityFetched) {
            return $this->abilities;
        }

        return $this->abilities = $this->fetchAbilitiesFromDb();
    }

    /**
     * Set role abilities;
     *
     * @param  string  $value
     * @return void
     */
    public function setAbilitiesAttribute($value)
    {
        $this->abilities = $value;
    }

    /**
     * Fetch abilities from database
     * 
     * @return \Illuminate\Support\Collection
     */
    protected function fetchAbilitiesFromDb()
    {
        $abilities = DB::table('role_abilities')->where('role_id', $this->id)->get();
        $this->abilityFetched = true;

        return $abilities->pluck('ability_id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model){
            DB::table('role_abilities')->where('role_id', $model->id)->delete();

            $abilities = [];
            foreach ($model->abilities as $ability) {
                $abilities[] = ['role_id' => $model->id, 'ability_id' => $ability];
            }

            DB::table('role_abilities')->insert($abilities);
        });

        static::deleting(function($model) {
            DB::table('role_abilities')->where('role_id', $model->id)->delete();
        });
    }
}
