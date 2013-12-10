<?php namespace Boutique\Storage;

use Boutique\Storage\Interfaces\StorageInterface;

class SessionStorage implements StorageInterface {

    /**
     * Flush the session
     * @return void
     */
    public function flush()
    {
        $_SESSION = array();
    }

    /**
     * Trash emtry in session
     * @param  string $key
     * @return void
     */
    public function trash($key)
    {
        $keys = explode('.', $key);

        $array =& $_SESSION;

        while (count($keys) > 1)
        {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) or ! is_array($array[$key]))
            {
                return;
            }

            $array =& $array[$key];
        }

        unset($array[array_shift($keys)]);
    }

    /**
     * Set entry in session
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function set($key, $value)
    {
        $keys = explode('.', $key);

        $array =& $_SESSION;

        while (count($keys) > 1)
        {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) or ! is_array($array[$key]))
            {
             $array[$key] = array();
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;
    }

    /**
     * Get entry from session
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default=null)
    {
        $keys = explode('.', $key);

        $return = $_SESSION;

        foreach( $keys as $key )
        {
            if( !isset($return[$key]) )
                return $default;

            $return = $return[$key];
        }

        return $return;
    }
}
