<?php

namespace Core {

  use Core\PORE\Config;
  use Core\PORE\Route;
  use Core\PORE\Trunk;
  use Core\PORE\Debug;
  use Core\PORE\Trunk\Duang;

  class PORE
  {

    public function __construct()
    {
      new Config;
      Route::_Init();
    }

    public static function running()
    {

      if (Config::$PORE['Debug'] == 'TRUE') {
        Debug::_Init();
      }

      Trunk::_Init(Config::$RUNNING['Trunk']);
    }

    //类自动加载
    public static function aLoad($_loadName)
    {
      //分割类名
      $_loadName = explode('\\', $_loadName);
      $c = count($_loadName);

      $i = 0;
      $RES = Config::$PACKAGE[$_loadName[$i]];

      do {
        if ($RES == TRUE) {
          $i++;
          $RES = $RES[$_loadName[$i]];
        } else {
          //错误的包名
          trigger_error('0x01');
          echo '0x01';
          die();
        }
      } while ($c - 1 > $i);

      //
      if (isset($RES['_Init']) == TRUE) {
        if (!require_once ROOT_PATH . $RES['_Init']) {
          //_Init 文件不存在
          trigger_error('0x02');
          echo '0x02';
          die();
        }
        $RES = $RES['_Init'];
      } else {
        if (!require_once ROOT_PATH . $_loadName[$i - 1] . '/' . $RES) {
          //RES 文件不存在
          trigger_error('0x03');
          echo '0x03';
        }
      }
    }

    //错误处理函数
    public static function WAR($_Error, $_Mgs, $_File, $_Line)
    {
      Duang::_Init([$_Error, $_Mgs, $_File, $_Line]);
    }
  }
}
