<?php
include_once __DIR__ . '\EntityDao.php';

abstract class Entity implements ArrayAccess
{
    public $id;

    public function __construct($arr = null)
    {
        if ($arr) {
            foreach ($arr as $key => $value) {
                if (property_exists($this, $key))
                    $this->$key = $value;
            }

            $this->sanitize();
        }
    }

    public function sanitize()
    {
    }

    /**
     * @return EntityDao
     */
    public static function dao()
    {
        $class = get_called_class();
        return new EntityDao(strtolower($class), $class);
    }

    /**
     * @param mixed $prop
     * @param string $type
     * @param bool $allow_arr
     */
    protected final function sanitize_property(&$prop, $type, $allow_arr = true)
    {
        if ($prop === null)
            return;

        if (is_array($prop)) {
            if (!$allow_arr) {
                $prop = null;
                return;
            } else {
                for ($i = 0; $i < sizeof($prop); $i++) {
                    if (!settype($prop[$i], $type)) {
                        unset($prop[$i]);
                        $i--;
                    }
                }
            }
        } elseif (!settype($prop, $type)) {
            $prop = null;
        }
    }

    /**
     * @param bool $allow_arr
     * @return array
     */
    public function to_db_array($allow_arr = true)
    {
        $result = array();

        foreach ($this as $key => $value) {
            if ($value == null)
                continue;

            if (is_array($value) && !$allow_arr)
                $result[$key] = $value[0];
            else
                $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function to_response_array()
    {
        return $this->to_db_array();
    }

    /**
     * @param Request $request
     * @return static
     */
    public static function from_request($request)
    {
        $result = self::create_instance();

        foreach ($result as $key => &$value) {
            $key = self::to_camel_case($key);
            $value = $request->get_param($key);
        }

        $result->sanitize();
        return $result;
    }

    /**
     * @return static
     */
    private static final function create_instance()
    {
        $class = get_called_class();
        return new $class();
    }

    /**
     * @param string $str
     * @return string
     */
    public static function to_camel_case($str)
    {
        return preg_replace_callback('/[a-z]_[a-z]/', function ($matches) {
            return $matches[0][0] . strtoupper($matches[0][2]);
        }, $str);
    }

    #region ArrayAccess

    /**
     * @param mixed $offset
     * @return bool
     */
    public final function offsetExists($offset)
    {
        return is_string($offset) ? property_exists($this, $offset) : false;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public final function offsetGet($offset)
    {
        return property_exists($this, $offset) ? $this->$offset : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public final function offsetSet($offset, $value)
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public final function offsetUnset($offset)
    {
        if (property_exists($this, $offset)) {
            $this->$offset = null;
        }
    }

    #endregion
}