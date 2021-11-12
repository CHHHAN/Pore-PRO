<?php
namespace Core\PORE {

  interface Airtas{
    public static function _Init();
  }

  class Airta
  {
    public static function _Init($_Airta)
    {
      if (isset(Config::$PACKAGE['Core']['PORE']['Airta'][$_Airta]) == TRUE) {
        $_Airta = '\\Core\\PORE\\Airta\\' . $_Airta;
        $_Airta::_Init();
      } else {
        echo '<h1>AIRTA 404!</h1>';
      }
    }
  }
}
