<?php

/**
 * Cached class used to store temporarily data while using prg (memcached can be use but need to be install)
 */
class Cached
{

    /**
     * list
     * @var array
     */
    public array $list = [];

    public function __construct()
    {
    }

    /**
     * set a value by a key
     * @param string $key
     * @param mixed $value
     * @param int $exirationTime in secondes
     * @return void
     */
    public function set(string $key, mixed $value, int $exirationTime): void
    {
        $this->list[$key] = ["expirationTime" => (date_timestamp_get(date_create()) + $exirationTime), "value" => $value];
    }

    /**
     * get a value by his key and remove it
     * @param int $key
     * @return mixed|null
     */
    public function getOnce(int $key): mixed
    {
        if (!isset($this->list[$key]))
            return null;

        $value = $this->list[$key]["value"];
        unset($this->list[$key]);
        return $value;
    }


    /**
     * Remove all expire value
     * @return void
     */
    public function checkExpired()
    {
        $date = date_timestamp_get(date_create());
        $this->list = array_filter($this->list, function ($var) use (&$date) {
            return $var["expirationTime"] >= $date;
        });
    }
}
