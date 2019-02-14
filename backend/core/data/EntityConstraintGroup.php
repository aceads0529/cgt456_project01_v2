<?php

class EntityConstraintGroup
{
    private $constraints;

    /**
     * EntityConstraintGroup constructor.
     * @param array $constraints
     */
    public function __construct($constraints = null)
    {
        $this->constraints = $constraints ? $constraints : array();
    }

    /**
     * @param string $name
     * @param mixed $constraint
     * @return $this
     */
    public function field($name, $constraint)
    {
        $op = '*';
        $entity = '*';
        $fields = '*';

        if ($name != '*') {
            list($op, $param) = explode('(', $name);

            $op = trim($op);
            $param = trim($param, '\t\n\r\0\x0B()');

            list($entity, $fields) = explode('::', $param);
            $entity = trim($entity);
            $fields = trim($fields);

            $entity = explode(',', $entity);
            $fields = explode(',', $fields);
        }

        $c = $this->constraints;

        foreach ($entity as $e) {
            $entity_constraint = isset($c[$e]) ? $c[$e] : new EntityConstraint();

            foreach ($fields as $f) {
                $entity_constraint->field($op . '/' . $f, $constraint);
            }

            $this->constraints[$e] = $entity_constraint;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param EntityConstraint $constraint
     * @return EntityConstraintGroup
     */
    public function entity($name, $constraint)
    {
        $this->constraints[$name] = $constraint;
        return $this;
    }

    /**
     * @param Entity $entity
     */
    public function filter(&$entity)
    {
        if (isset($this->constraints[$k = get_class($entity)])) {
            $this->constraints[$k]->filter($entity);
        } elseif (isset($this->constraints[$k = '*'])) {
            $this->constraints[$k]->filter($entity);
        }
    }
}