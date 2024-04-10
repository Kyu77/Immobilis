<?php

class Database {


    private static ?PDO $instance = null;

    public static function dbConnection() : PDO{
        if(self::$instance === null){
            try{
                self::$instance = new PDO("mysql:host=localhost;dbname=immobilis","root", "15082003hdc");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }catch (PDOException $exception){
                echo $exception->getMessage();
            }
        }
        return self::$instance;
    }
}