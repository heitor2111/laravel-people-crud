<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonProfession
 *
 * @property int $id
 * @property int $person_id
 * @property int $profession_id
 *
 * @property Person $person
 * @property Profession $profession
 *
 * @package App\Models
 */
class PersonProfession extends Model
{
    use HasFactory;
    protected $table = 'person_professions';
    public $timestamps = false;

    protected $casts = [
        'person_id' => 'int',
        'profession_id' => 'int'
    ];

    protected $fillable = [
        'person_id',
        'profession_id'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
