<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 *
 * @property int $id
 * @property string $description
 * @property string $contact
 * @property int $person_id
 *
 * @property Person $person
 *
 * @package App\Models
 */
class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    public $timestamps = false;

    protected $casts = [
        'person_id' => 'int'
    ];

    protected $fillable = [
        'description',
        'contact',
        'person_id'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
