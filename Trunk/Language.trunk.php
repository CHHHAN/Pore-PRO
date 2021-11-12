<?php
namespace Core\PORE\Trunk {

  use Core\PORE\Interfaces\Trunk;
  use Core\PORE\Airta;
    use Core\PORE\Config;

class Language implements Trunk
  {

    public static $_Language;

    public static function _Init($_Airta)
    {

      self::$_Language = file_get_contents(RES_PATH . Config::$PACKAGE['Core']['PORE']['Resource']['Language']);
      self::$_Language = json_decode(self::$_Language,true);

      Airta::_Init($_Airta);
    }
    public static function _GET($_Class, $_Name)
    {
      
      //分割类名
      $_Class = explode('\\', $_Class);
      $c = count($_Class);

      $i = 0;
      $RES = self::$_Language[Config::$RUNNING['Trunk']][$_Class[$i]];

      // ::$PACKAGE[$_Class[$i]];

      do {
        if ($RES == TRUE) {
          $i++;
          $RES = $RES[$_Class[$i]];
        } else {
          echo '错误的包名' . $_Class[$i] . '<br>';
          die();
        }
      } while ($c - 1 > $i);

      return $RES[$_Name];
    }
  }
}
