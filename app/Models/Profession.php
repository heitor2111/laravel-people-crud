<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profession
 *
 * @property int $id
 * @property string $name
 *
 * @property Collection|Person[] $people
 *
 * @package App\Models
 */
class Profession extends Model
{
    use HasFactory;
    protected $table = 'professions';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'person_professions')
            ->withPivot('id');
    }
}
