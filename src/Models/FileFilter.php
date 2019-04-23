<?php

namespace Belca\File\Models;

use EloquentFilter\ModelFilter;

/**
 * Реализует фильтры модели.
 *
 * Фильтры используются при поиске значений на основе группы условий и
 * обеспечивают простой, минимальный и понятный синтаксис в контроллерах или
 * репозиториях.
 */
class FileFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function title($title)
    {
         return $this->where('title', 'LIKE', "%$title%");
    }

    // TODO поиск по slug, типу файла, расширению, группе, источнику и всем полям файла
}
