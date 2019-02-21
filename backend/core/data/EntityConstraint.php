<?php

class EntityConstraint
{
    private $constraints;

    /**
     * EntityConstraint constructor.
     * @param mixed $constraints
     */
    public function __construct($constraints = null)
    {
        $this->initialize_constraints($constraints);
    }

    /**
     * @param string $name
     * @param mixed $constraint
     * @return $this
     */
    public function field($name, $constraint)
    {
        $this->initialize_constraints([$name => $constraint]);
        return $this;
    }

    private function initialize_constraints($c)
    {
        if ($c === null)
            return;

        foreach ($c as $key => $value) {
            if (sizeof($key_split = explode('/', $key)) > 1
                && sizeof($action_split = explode(',', $key_split[0])) > 1) {
                foreach ($action_split as $a) {
                    $this->constraints[$a . '/' . $key_split[1]] = $value;
                }
            } else {
                $this->constraints[$key] = $value;
            }
        }
    }

    /**
     * @param Entity $entity
     * @param string $action
     */
    public function filter(&$entity, $action = null)
    {
        foreach ($entity as $key => &$value) {
            $this->restrict_property($value, $this->get_constraint($action, $key));
        }
    }

    private function get_constraint($action, $prop)
    {
        if (isset($this->constraints[$k = $action . '/' . $prop]))
            return $this->constraints[$k];
        elseif (isset($this->constraints[$k = '*/' . $prop]))
            return $this->constraints[$k];
        elseif (isset($this->constraints[$k = '*/*']))
            return $this->constraints[$k];
        else
            return null;
    }

    /**
     * @param Entity $prop
     * @param mixed $constraint
     */
    private function restrict_property(&$prop, $constraint)
    {
        $constraint = $this->get_property_array($constraint);
        $field = $this->get_property_array($prop);

        if ($constraint !== null) {
            if ($field !== null) {
                $field = array_intersect($field, $constraint);
                $field = array_values($field);
            } else {
                $field = $constraint;
            }

            if (sizeof($field) === 1)
                $field = $field[0];

            $prop = $field;
        }
    }

    /**
     * @param mixed $prop
     * @return array|null
     */
    private function get_property_array($prop)
    {
        if ($prop !== null) {
            if ($prop === 'all')
                return null;
            elseif ($prop === 'none')
                return array();

            if (is_callable($prop)) {
                $prop = $prop();
            }

            if (!is_array($prop)) {
                $prop = [$prop];
            }
        }

        return $prop;
    }

    private static function get_or_default(&$var, $default = null)
    {
        return isset($var) ? $var : $default;
    }
}