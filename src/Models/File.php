<?php

namespace Dios\System\File\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Keeps data of a file and its modifications.
 *
 * @property int $id An ID of the file.
 * @property string $source A source of the file.
 * @property int|null $parent_id A parent file.
 * @property string $path A relative path to the file.
 * @property int $size Size of the file.
 * @property string $disk A disk where is the file.
 * @property string $mime MIME-type of the file.
 * @property string $driver A driver that modified the file.
 * @property string $handler A method or a way of modification of the file.
 * @property string $handler_mode A mode of the method (the handler) of the file.
 * @property string $title A title of the file.
 * @property string|null $extension An extention of the file.
 * @property string|null $description A description of the file.
 * @property bool $active A state of a file accessibility.
 * @property string|null $slug A slug to download the file.
 * @property string $options
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
