<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $person_id
 *
 * @property Person $person
 *
 * @package App\Models
 */
class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = false;

    protected $casts = [
        'person_id' => 'int'
    ];

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'username',
        'password',
        'person_id'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
