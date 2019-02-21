<?php
include_once __DIR__ . '\Entity.php';
include_once __DIR__ . '\Dao.php';

abstract class EntityDao extends Dao
{
    /**
     * @param int[]|string[] ...$ids
     * @return mixed
     */
    abstract function select(...$ids);

    /**
     * @param Entity $entity
     * @return boolean
     */
    abstract function insert(&$entity);

    /**
     * @param Entity $entity
     * @return boolean
     */
    abstract function update($entity);

    /**
     * @param int[]|string[] ...$ids
     * @return boolean
     */
    abstract function delete(...$ids);
}
