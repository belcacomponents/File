<?php

namespace Belca\File\Contracts;


use Prettus\Repository\Contracts\RepositoryInterface;

interface FileRepository extends RepositoryInterface
{
    /**
     * Создает объект с заданием значений защищенных полей, которые перечислены
     * в массиве $guarded или определены автоматически.
     *
     * @param  array $attributes Данные ввода
     * @param  array  $guarded    Список защищенных полей, которые будут заполнены
     * @return mixed
     */
    public function createWithGuardedFields($attributes, $guarded = []);

    /**
     * Создает объект с заданием значений защищенных полей указанных в
     * массиве $guardedValues в виде "имя поля" - "значение".
     *
     * @param  array $attributes     Данные ввода
     * @param  array  $guardedValues Значения защищенных полей
     * @return mixed
     */
    public function createWithGuardedValues($attributes, $guardedValues = []);

    public function createModifications($id, $modifications);

    // TODO также для связи с модификациями
}
