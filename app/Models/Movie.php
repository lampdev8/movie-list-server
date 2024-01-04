<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class Movie extends Model
{
    use HasFactory;

    private const API_VERSION = 'api/v1/';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'year',
        'poster',
        'genre_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $attributes = [
        'genre_name',
    ];

    protected $appends = [
        'genre_name',
    ];

    /**
     * Get the poster
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function poster(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url(self::API_VERSION . $value),
        );
    }

    /**
     * Get the genre
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the poster
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getGenreNameAttribute()
    {
        return $this->genre->name;
    }
}
