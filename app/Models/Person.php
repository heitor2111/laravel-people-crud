<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Person
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $document
 * @property Carbon|null $birth_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Collection|Contact[] $contacts
 * @property Collection|Profession[] $professions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Person extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'people';

    protected $dates = [
        'birth_date'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'document',
        'birth_date'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class, 'person_professions')
            ->withPivot('id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
