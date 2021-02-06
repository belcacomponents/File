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
 * @property bool $active A state of activity of the file.
 * @property bool $published A state of a file accessibility from the Web.
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
     * Returns files which has a slug.
     */
    public function scopeHasSlug(Builder $query): Builder
    {
        return $query->whereNotNull('slug');
    }

    /**
     * Returns active files.
     *
     * @param Builder $query
     * @param boolean $active A state of activity of files.
     */
    public function scopeActive(Builder $query, bool $active = true): Builder
    {
        return $query->where('active', $active);
    }

    /**
     * Returns published files.
     *
     * @param Builder $query
     * @param boolean $published A publication state of files.
     */
    public function scopePublished(Builder $query, bool $published = true): Builder
    {
        return $query->where('published', $published);
    }

    /**
     * Returns really published files. They are active published files
     * which has a slug.
     */
    public function scopeReallyPublished(Builder $query): Builder
    {
        return $query->active()->published()->hasSlug();
    }

    /**
     * Returns files by the given slug.
     *
     * @param  Builder $query
     * @param  string  $slug
     * @return Builder
     */
    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Returns files by the given driver.
     *
     * @param  Builder $query
     * @param  string  $driver
     * @return Builder
     */
    public function scopeDriver(Builder $query, string $driver): Builder
    {
        return $query->where('driver', $driver);
    }

    /**
     * Returns files by the given handler.
     *
     * @param  Builder $query
     * @param  string  $handler
     * @return Builder
     */
    public function scopeHandler(Builder $query, string $handler): Builder
    {
        return $query->where('handler', $handler);
    }

    /**
     * Returns files by the given handler mode.
     *
     * @param  Builder $query
     * @param  string  $mode
     * @return Builder
     */
    public function scopeHandlerMode(Builder $query, string $mode): Builder
    {
        return $query->where('handler_mode', $mode);
    }

    /**
     * Checks whether the file has loaded modifications.
     *
     * @return bool
     */
    public function hasLoadedModifications(): bool
    {
        return $this->relationLoaded('modifications');
    }

    /**
     * Checks whether the file has loaded related modifications.
     *
     * @return bool
     */
    public function hasModifications(): bool
    {
        return $this->hasLoadedModifications() && $this->modifications->count();
    }

    /**
     * Initializes and returns a collection with the given files.
     *
     * @param  array|File[] $models
     * @return FileCollection
     */
    public function newCollection(array $models = []): FileCollection
    {
        return new FileCollection($models);
    }
}
