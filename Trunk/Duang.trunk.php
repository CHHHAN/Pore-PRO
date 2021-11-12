<?php

namespace Core\PORE\Trunk {

   /**
    *
    *   图标   值     常量                   描述
    *   ⚠️    2      E_WARNING             非致命的 run-time 错误。不暂停脚本执行。
    *   ℹ️    8      E_NOTICE              run-time 通知。在脚本发现可能有错误时发生，但也可能在脚本正常运行时发生。
    *   ❌    256    E_USER_ERROR          致命的用户生成的错误。这类似于程序员使用 PHP 函数 trigger_error() 设置的 E_ERROR。
    *   ⚠️    512    E_USER_WARNING        非致命的用户生成的警告。这类似于程序员使用 PHP 函数 trigger_error() 设置的 E_WARNING。
    *   ℹ️    1024   E_USER_NOTICE         用户生成的通知。这类似于程序员使用 PHP 函数 trigger_error() 设置的 E_NOTICE。
    *   🔌    4096   E_RECOVERABLE_ERROR   可捕获的致命错误。类似 E_ERROR，但可被用户定义的处理程序捕获。（参见 set_error_handler()）
    *   ⛔️    8191   E_ALL                 所有错误和警告。（在 PHP 5.4 中，E_STRICT 成为 E_ALL 的一部分）
    */

   use Core\PORE\Interfaces\Trunk;

   class Duang implements Trunk
   {

      public static $_Type, $_Mgs, $_File, $_Line;

      public static function _Init($_Error)
      {

         self::$_Type = $_Error[0];
         self::$_Mgs = $_Error[1];
         self::$_File = $_Error[2];
         self::$_Line = $_Error[3];

         if ($_Error[0] == 2 or  $_Error[0] == 512) {
            self::Warning();
         } elseif ($_Error[0] == 8 or  $_Error[0] == 1024) {
            self::Information();
         } elseif ($_Error[0] == 256) {
            self::Error();
         } elseif ($_Error[0] == 4096) {
            self::Final();
         } elseif ($_Error[0] == 8191) {
            self::Exit();
         } else {
            self::UnKnow();
         }

      }
      public static function Warning()
      {
         echo '<h3>Warning</h3>';
         echo '<b>MGS: </b>'.self::$_Mgs.'<br>';
         echo '<b>FILE: </b>'.self::$_File.'<br>';
         echo '<b>LINE: </b>'.self::$_Line.'<br>';
      }

      public static function Information()
      {
         echo '<h3>Information</h3>';
         echo '<b>MGS: </b>'.self::$_Mgs.'<br>';
         echo '<b>FILE: </b>'.self::$_File.'<br>';
         echo '<b>LINE: </b>'.self::$_Line.'<br>';
      }

      public static function Error()
      {
         echo '<h3>Error</h3>';
         echo '<b>MGS: </b>'.self::$_Mgs.'<br>';
         echo '<b>FILE: </b>'.self::$_File.'<br>';
         echo '<b>LINE: </b>'.self::$_Line.'<br>';
      }

      public static function Final()
      {
         echo '<h3>Final</h3>';
         echo '<b>MGS: </b>'.self::$_Mgs.'<br>';
         echo '<b>FILE: </b>'.self::$_File.'<br>';
         echo '<b>LINE: </b>'.self::$_Line.'<br>';
      }

      public static function Exit()
      {
         echo '<h3>Exit</h3>';
         echo '<b>MGS: </b>'.self::$_Mgs.'<br>';
         echo '<b>FILE: </b>'.self::$_File.'<br>';
         echo '<b>LINE: </b>'.self::$_Line.'<br>';
      }

   }
}
