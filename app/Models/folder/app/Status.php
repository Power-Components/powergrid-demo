<?php

namespace App\Models\folder\app;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Database Connection Name
     */
    protected $connection = 'db1';

    /**
     * Model Table Name
     */
    protected $table = 'possible_events_status';

    /**
     * Model Primary Key
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeSearch($query, $params)
    {
        if (!empty($params)) {
            return $query->where('name', 'like', '%'.$params.'%');
        }
        return null;
    }
}
