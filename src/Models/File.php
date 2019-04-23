<?php

namespace Belca\File\Models;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class File extends Model
{
    use Filterable;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'published',
        'category_id'
    ];

    // TODO скрыты все кроме стандартных полей title description path
    //protected $hidden = ['slug', 'name', 'published'];

    /**
     * Возвращает класс фильтра.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(FileFilter::class);
    }

    /**
     * Возвращает экземпляры модификаций файла.
     */
    public function modifications()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Возвращает родительский экземпляр файла.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'id');
    }

    /**
     * Возвращает только родительские (оригинальные) файлы.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeOriginal($query)
    {
        return $query->where('parent_id', '0');
    }

    /**
     * Условие отображения опубликованных файлов. Если $published - false,
     * то возвращает неопубликованные файлы.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  boolean                              $query Состояние публикации
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query, $published = true)
    {
        return $query->where('published', $published);
    }

    // TODO если это вынести в репозиторий, то здесь это потеряет смысл
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value, '-');
    }

    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = ($value) ? $value : false;
    }
}
