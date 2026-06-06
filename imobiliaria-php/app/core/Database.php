<?php 

class Database {
    private static $pdo = null;

    public static function connect(){
        if (self::$pdo === null)    
            {
                try {
                    $caminhoBanco = __DIR__  . '/../../database/database.sqlite';

                    self::$pdo = new PDO("sqlite:" . $caminhoBanco);

                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


                }catch(PDOException $e){
                    die("Falha na conexão com o Banco de Dados: ". $e->getMessage());
                }
            }
            return self::$pdo;
        }
}

?>