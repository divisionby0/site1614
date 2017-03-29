<?php

class Logger {

    private static $fileLogging;

    private static $fileLoggingEnabled = false;

    public static function setFile($file){
        self::$fileLogging = new Logging();
        self::$fileLogging->lfile($file);
        
        self::$fileLoggingEnabled = true;
    }

    public static function logMessage($text){
        echo '<p style="font-size: 11px; background-color: white; color: blue;">'.$text.'</p>';
        
        if(self::$fileLoggingEnabled){
            self::$fileLogging->lwrite($text);
            self::$fileLogging->lclose();
        }
    }
    public static function logError($error){
        echo '<p style="color: red; background-color:white; font-size: 11px">'.$error.'</p>';
        if(self::$fileLoggingEnabled){
            self::$fileLogging->lwrite($error);
            self::$fileLogging->lclose();
        }
    }
} 