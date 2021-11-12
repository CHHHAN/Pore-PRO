<?php
namespace Core\PORE {

  use Core\PORE\Config;
  use Core\PORE\Trunk\Language;
  
  class Trunk
  {
    public static function _Init($_Trunk)
    {
      if (isset(Config::$PACKAGE['Core']['PORE']['Trunk'][$_Trunk]) == TRUE) {
        $_Trunk = '\\Core\\PORE\\Trunk\\'.$_Trunk;
        echo $_Trunk;
        $_Trunk::_Init();
      } else {
        Language::_Init(Config::$RUNNING['Airta']);
      }
    }
  }
}
