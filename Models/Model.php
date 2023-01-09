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
    public static function executeRequest(string $sql,array $params = null)
    {
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
    private static function getBdd():PDO
    {
        if (Modele::$bdd != null) return Modele::$bdd;
        Modele::$bdd = new PDO('mysql:host=localhost;dbname=web4shop;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return Modele::$bdd;
    }

    /**
     * Return last id inserted 
     * @return int
     */
    protected static function lastInsertId():int
    {
        return Modele::getBdd()->lastInsertId();
    }

    /**
     * Return an instance by his id
     * @param string|int $id
     * @return ?static
     */
    public static function getInstanceByID(string|int $id): ?static{
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
    public static function &create(array $data): static{
        $instance = (object) new static($data);
        if(!array_key_exists(static::class, self::$instances)){
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
    protected static function fetchAll(string $sql,array $params = null):array
    {   
        self::$requestlist[] = [$sql, $params];
        $response = Modele::executeRequest($sql, $params);
        $array = [];
        foreach( $response->fetchAll() as $element){
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
    protected static function fetch(string $sql,array $params = null):?object
    {
        self::$requestlist[] = [$sql, $params];
        $response = Modele::executeRequest($sql, $params);
        $result = $response->fetch();
        if (!$result)
            return null;
        return static::create($result);
    }

    public static function showRequests(){
        echo "<pre>";
        print_r(self::$requestlist);
        echo "</pre>";
    }
}
