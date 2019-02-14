<?php
include_once __DIR__ . '\DaoConnection.php';

class DaoQuery
{
    const
        SELECT = 1,
        INSERT = 2,
        INSERT_IGNORE = 3,
        UPDATE = 4,
        DELETE = 5;

    private
        $query_type,
        $columns,
        $tables,
        $where,
        $group_by,
        $values;

    private $alias;

    /**
     * DaoQuery constructor.
     * @param int $query_type
     */
    public function __construct($query_type)
    {
        $this->query_type = $query_type;
        $this->where = array();
        $this->tables = array();
        $this->group_by = array();
        $this->values = array();
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string ...$tables
     * @return $this
     */
    public function tables(...$tables)
    {
        $this->tables = array_merge($this->tables, $this->array_flatten($tables));
        return $this;
    }

    /**
     * @param string ...$columns
     * @return $this
     */
    public function columns(...$columns)
    {
        $this->columns = self::array_flatten($columns);
        return $this;
    }

    /**
     * @param mixed ...$params
     * @return $this
     */
    public function values(...$params)
    {
        foreach ($params as &$p) {
            $p = self::to_clean_array($p);
            $this->values[] = $p;
        }

        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function where($params)
    {
        $params = self::to_clean_array($params);

        if (is_string($params)) {
            $this->where[':' . md5($params)] = $params;
        } else {
            $this->where = array_merge($this->where, $params);
        }

        return $this;
    }

    /**
     * @param string ...$cols
     * @return $this
     */
    public function group_by(...$cols)
    {
        $params = self::array_flatten($cols);
        $this->group_by = array_merge($this->group_by, $params);

        return $this;
    }

    /**
     * @return array|null
     */
    public function compile()
    {
        switch ($this->query_type) {
            case DaoQuery::SELECT:
                return $this->compile_select();
            case DaoQuery::INSERT:
                return $this->compile_insert();
            case DaoQuery::INSERT_IGNORE:
                return $this->compile_insert(true);
            case DaoQuery::DELETE:
                return $this->compile_delete();
            default:
                return null;
        }
    }

    /**
     * @return array|bool
     */
    private function compile_select()
    {
        $templ = 'SELECT %s FROM %s %s %s';

        $tables = implode(', ', $this->tables);
        $columns = $this->columns ? implode(', ', $this->columns) : '*';

        list($where_clause, $params) = $this->get_where_clause_and_params();

        $group_by = $this->group_by
            ? 'GROUP BY ' . implode(', ', $this->group_by)
            : '';

        $query_str = sprintf($templ, $columns, $tables, $where_clause, $group_by);
        return [$query_str, $params];
    }

    /**
     * @param bool $ignore
     * @return array|bool
     */
    private function compile_insert($ignore = false)
    {
        $templ = ($ignore ? 'INSERT IGNORE ' : 'INSERT ') . 'INTO %s (%s) VALUES %s';

        if (!$this->columns)
            return false;

        $table = $this->tables[0];
        $columns = $this->columns ? implode(', ', $this->columns) : '*';

        list($insert_clause, $params) = $this->get_insert_clause_and_params();
        $query_str = sprintf($templ, $table, $columns, $insert_clause);

        return [$query_str, $params];
    }

    private function compile_delete()
    {
        $templ = 'DELETE FROM %s %s';
        $tables = implode(', ', $this->tables);

        list($where_clause, $params) = $this->get_where_clause_and_params();

        $query_str = sprintf($templ, $tables, $where_clause);
        return [$query_str, $params];
    }

    private function get_table_clause_and_params()
    {
        $clauses = array();
        $params = array();

        $tables = $this->tables;

        foreach ($tables as $t) {
            if (gettype($t) == 'DaoQuery') {
                $query = [$t, 'compile'];
                list($clause, $params) = $query();
                $clauses[] = sprintf('(%s) %s', self::wrap_str($clause, '()'), $this->alias);
                $params = array_merge($params);
            } else {
                $clauses[] = $t;
            }
        }

        return [implode(', ', $clauses)];
    }

    /**
     * @return array(string, array)
     */
    public function get_insert_clause_and_params()
    {
        $clauses = array();
        $params = array();

        $cols = $this->columns;

        if (!$cols)
            return ['', $params];

        foreach ($this->values as $value) {
            $question_marks = array();

            foreach ($cols as $key => $col) {
                $question_marks[] = '?';
                $params[] = isset($value[$col]) ? $value[$col] : null;
            }

            $clauses[] = self::wrap_str(implode(', ', $question_marks), '()');
        }

        return [implode(', ', $clauses), $params];
    }

    /**
     * @return array(string, array)
     */
    private function get_where_clause_and_params()
    {
        $clauses = array();
        $params = array();

        foreach ($this->where as $key => $value) {
            $key = trim($key);

            if ($key[0] == ':') {
                $clauses[] = $value;
            } elseif (is_array($value)) {
                $question_marks = array_fill(0, sizeof($value), '?');
                $question_marks = implode(', ', $question_marks);
                $clauses[] = $key . ' IN ' . self::wrap_str($question_marks, '()');
                $params = array_merge($params, $value);
            } else {
                if (sizeof($split = explode(' ', $key)) == 2 && $split[1] == 'LIKE') {
                    $clauses[] = $key . ' ?';
                } else {
                    $clauses[] = $key . ' = ?';
                }

                $params[] = $value;
            }
        }

        if (sizeof($clauses) == 0)
            $clauses = '';
        else
            $clauses = 'WHERE ' . self::wrap_str(implode(') AND (', $clauses), '()');

        return [$clauses, $params];
    }

    /**
     * @param mixed $obj
     * @return array|string
     */
    private static function to_clean_array($obj)
    {
        if (is_string($obj))
            return $obj;

        if (is_object($obj))
            $obj = get_object_vars($obj);

        $clean = array();
        foreach ($obj as $key => $value) {
            if ($value !== null) {
                $clean[$key] = $value;
            }
        }

        return $clean;
    }

    /**
     * @param array $arr
     * @return array
     */
    public static function array_flatten($arr)
    {
        $result = array();

        foreach ($arr as $a) {
            if (is_array($a)) {
                $a = self::array_flatten($a);
                $result = array_merge($result, $a);
            } else
                $result[] = $a;
        }

        return $result;
    }

    /**
     * @param array $arr
     */
    private static function array_sanitize(&$arr)
    {
        while (($key = key($arr)) !== null) {
            $key = key($arr);
            if ($arr[$key] === null)
                unset ($arr[$key]);

            next($arr);
        }
    }

    /**
     * @param string $str
     * @param string $caps
     * @return string
     */
    private static function wrap_str($str, $caps)
    {
        return $caps[0] . $str . $caps[1];
    }
}
