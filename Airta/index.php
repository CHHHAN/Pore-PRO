<?php
namespace Core\PORE\Airta {

  use Core\PORE\Interfaces\Airta;
  use Core\PORE\Library\Pock;
  use Core\PORE\Trunk\Language;

class index implements Airta
  {
    public static function _Init()
    {
      index::main();
    }

    

    //  Pock 非对称加密算法
    public static function main()
    {
      echo '<h1>Hello, Pore PRO!</h1>';
    }
  }
}
