<?php

/**
 * Base modele class
 */
abstract class Modele
{
    /**
     *  List of all request executed (DEBUGGING)
     */
    private static array $requestlist = [];

    /**
     * List of all instances by ID
     * @var array
     */
    public static array $instances = [];

    /**
     * PDO instance
     * @var PDO|null
     */
    private static PDO|null $bdd = null;

    /**
     * Execute sql request
     * @param string $sql sql request
     * @param array|null $params sql bind values
     * @return PDOStatement|bool
     */
    public static function executeRequest(string $sql, array $params = null)
    {
        self::$requestlist[] = [$sql, $params];

        if ($params == null) {
            $resultat = Modele::getBdd()->query($sql);
        } else {
            $resultat = Modele::getBdd()->prepare($sql);
            $resultat->execute($params);
        }
        return $resultat;
    }

    /**
     * Return PDO instance
     * @return PDO
     */
    private static function getBdd(): PDO
    {
        if (Modele::$bdd != null) return Modele::$bdd;
        Modele::$bdd = new PDO('mysql:host=localhost;dbname=web4shop;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        return Modele::$bdd;
    }

    /**
     * Return last id inserted 
     * @return int
     */
    protected static function lastInsertId(): int
    {
        return Modele::getBdd()->lastInsertId();
    }

    /**
     * Return an instance by his id
     * @param string|int $id
     * @return ?static
     */
    public static function getInstanceByID(string|int $id): ?static
    {
        if (array_key_exists(static::class, self::$instances)) {
            if (array_key_exists(strval($id), self::$instances[static::class])) {
                return self::$instances[static::class][strval($id)];
            }
        }
        return null;
    }

    /**
     * Create a new instance and save it
     * @param array $data
     * @return object
     */
    public static function &create(array $data): static
    {
        $instance = (object) new static($data);
        if (!array_key_exists(static::class, self::$instances)) {
            self::$instances[static::class] = [];
        }
        self::$instances[static::class][strval($instance->getId())] = $instance;
        return self::$instances[static::class][strval($instance->getId())];
    }


    /**
     * Return all element as class instances in array
     * @param string $sql sql request
     * @param array|null $params sql bind values
     * @return array
     */
    protected static function fetchAll(string $sql, array $params = null): array
    {
        $response = Modele::executeRequest($sql, $params);
        $array = [];
        foreach ($response->fetchAll() as $element) {
            $array[] = static::create($element);
        }
        return $array;
    }

    /**
     * Return first element as class instance
     * @param string $sql sql request
     * @param array|null $params sql bind values
     * @return object|null
     */
    protected static function fetch(string $sql, array $params = null): ?object
    {
        $response = Modele::executeRequest($sql, $params);
        $result = $response->fetch();
        if (!$result)
            return null;
        return static::create($result);
    }

    public static function showRequests()
    {
        echo "<pre>";
        print_r(self::$requestlist);
        echo "</pre>";
    }

    /**
     * check if $value is between $min and max
     * @param mixed $value
     * @param int $min
     * @param int $max
     * @param string $attributName
     * @throws FormException
     * @return void
     */
    protected static function checkValueBetween(mixed $value, int $min, int $max, string $attributName, bool $float = false)
    {
        if (!is_numeric($value)) throw  new FormException("Le champ doit etre un nombre", $attributName);
        if ($float) {
            $value = floatval($value);
        } else {
            $value = intval($value);
        }
        if ($value < $min) {
            throw new FormException("La valeurs doit être supérieur à $min !", $attributName);
        } else if ($value > $max) {
            throw new FormException("La valeurs doit être inferieur à $max !", $attributName);
        }
    }

    /**
     * check if length of $value is between $min and max
     * @param mixed $value
     * @param int $min
     * @param int $max
     * @param string $attributName
     * @throws FormException
     * @return void
     */
    protected static function checkLengthBetween(mixed $value, int $min, int $max, string $attributName)
    {
        $value = strval($value);
        $length = mb_strlen($value, "utf-8");
        if ($length < $min) {
            throw new FormException("Le champ doit au moins faire $min caractères !", $attributName);
        } else if ($length > $max) {
            throw new FormException("Le champ ne doit pas faire plus de $max caractères !", $attributName);
        }
    }
}
