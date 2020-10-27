<?php

namespace Dios\System\File\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Keeps data of a file and its modifications.
 */
class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Returns modifications of the file.
     */
    public function modifications(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    /**
     * Returns a parent file.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'id');
    }

    /**
     * Returns only original (parent) files.
     */
    public function scopeOriginal(Builder $query): Builder
    {
        return $query->where('parent_id', 0);
    }

    /**
     * Условие отображения опубликованных файлов. Если $published - false,
     * то возвращает неопубликованные файлы.
     *
     * @param Builder  $query
     * @param boolean  $active
     */
    public function scopeActive(Builder $query, bool $active = true): Builder
    {
        return $query->where('active', $active);
    }

    // TODO поиск по slug, типу файла, расширению, группе, источнику и всем полям файла
}
