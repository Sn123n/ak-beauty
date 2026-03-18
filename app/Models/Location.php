<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $fillable = [
        'location_id',
        'name',
        'location_type',
        'parent_id',
    ];
    public $timestamps = false;

    protected $primaryKey = 'location_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('location_type', $type);
    }

    public static function deleteCountry($id)
    {
        $country = self::find($id);

        if ($country && $country->location_type == 0) {
            $states = $country->children()->ofType(1)->get();
            foreach ($states as $state) {
                $state->children()->ofType(2)->delete();
            }

            $country->children()->ofType(1)->delete();

            return $country->delete();
        }

        return false;
    }

    public static function deleteState($id)
    {
        $state = self::find($id);

        if ($state && $state->location_type == 1) {
            $state->children()->ofType(2)->delete();

            return $state->delete();
        }

        return false;
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
