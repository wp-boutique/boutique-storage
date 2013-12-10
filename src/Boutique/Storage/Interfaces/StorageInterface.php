<?php namespace Boutique\Storage\Interfaces;

interface StorageInterface {

    public function flush();

    public function trash($key);

    public function set($key, $value);

    public function get($key, $default=null);

}