<?php
class Remote
{
    protected $db;

    public function __construct()
    {
        require_once (__DIR__ . "../../div0/DBConfig.php");
        
        $dsn = 'mysql:host='.DBConfig::$DBHOST.';dbname='.DBConfig::$DBNAME.';charset='.DBConfig::$DBCHARSET;
        $options = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try{
            $this->db = new PDO($dsn, DBConfig::$DBUSER, DBConfig::$DBPASS, $options);
        }
        catch(Exception $exception){
            echo '<h1 style="color: red;">Error connecting to data base</h1>';
        }
    }
}