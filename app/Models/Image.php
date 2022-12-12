<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Model relations
    /**
     * images related album
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album(){
        return $this->belongsTo(Album::class);
    }
}
