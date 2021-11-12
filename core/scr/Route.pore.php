<?php
namespace Core\PORE {

  use Core\PORE;
  use Core\PORE\Config;
  use Core\PORE\Library\STR;

  class Route
  {
    public static function _Init()
    {
      $URL = $_SERVER['REQUEST_URI'];
      $RES = STR::cut('?', $URL, 2);  //分割'?'内容
      $URL = $RES[0];  //URL去'?'
      $URL = STR::delSS($URL, '/');  //去除两边'/'
      $RES = STR::cut('/', $URL, 3); //分类'/'
      $NUM = count($RES); //参数数量
      if ($NUM == 1) { //如果只有一个参数
        if ($RES[0] == '') { //如果语言参数为空
          //配置默认值
          Config::$RUNNING['Trunk'] = Config::$PORE['Trunk'];
          Config::$RUNNING['Airta'] = Config::$PORE['Airta'];
          Config::$RUNNING['Param'] = Config::$PORE['Param'];
        } else { //如果语言参数不是空的
          //配置语言参数
          Config::$RUNNING['Trunk'] = $RES[0];
          //配置其他参数为默认值
          Config::$RUNNING['Airta'] = Config::$PORE['Airta'];
          Config::$RUNNING['Param'] = Config::$PORE['Param'];
        }
      }
      if ($NUM == 2) { //如果只有两个参数
        //配置两个参数
        Config::$RUNNING['Trunk'] = $RES[0];
        Config::$RUNNING['Airta'] = $RES[1];
        //配置请求参数为默认值   //请求参数设为空
        Config::$RUNNING['Param'] = '';
      }
      if ($NUM >= 3) { //如果有三个参数以上
        //配置三个参数
        Config::$RUNNING['Trunk'] = $RES[0];
        Config::$RUNNING['Airta'] = $RES[1];
        Config::$RUNNING['Param'] = $RES[2];
      }

      //进入Trunk
      PORE::running();
    }
  }
}
