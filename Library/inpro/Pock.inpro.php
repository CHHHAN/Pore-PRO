<?php

namespace Core\PORE\Library {

   use Core\PORE\Interfaces\Library;
   use Core\PORE\Library\STR;

   class Pock implements Library
   {

      /**
       * 库信息
       */
      const _Info = [
         'Library' => 'Pock',
         'Dependency' => ['STR'],
         'Author' => 'Prother',
         'README' => '简介链接'
      ];

      public static function _Info()
      {
         return [
            'Library' => 'Pock',
            'Dependency' => ['STR'],
            'Author' => 'Prother',
            'README' => '简介链接'
         ];
      }

      /**
       * 生成一对 Key
       * @param int $_Number 创建Key位数，一般为9
       * @return array ['UPW']加密钥匙 ['LOW']解密钥匙
       */
      public static function Even(int $_Number)
      {
         $UPW = STR::hitCode($_Number);  //加密钥匙
         $upwAuto = STR::hitCode(3);     //加密钥匙 配对值

         $LOW = STR::authcode($UPW, 'lock', $upwAuto);  //解密钥匙 [ 加密钥匙 authcode 配对值 ]
         $lowAuto = STR::hitCode(3);                    //解密钥匙 配对值

         //对钥匙进行混淆
         $UPW = $lowAuto . $UPW;         //解密钥匙 配对值 + 加密钥匙  / 加密
         $LOW = $LOW . $upwAuto;   //解密钥匙 + 加密钥匙配对值   / 解密

         return [
            'UPW' => $UPW,
            'LOW' => $LOW
         ];
      }

      /**
       * 测试 Key 有效性
       * @param string $_UPW 加密钥匙
       * @param string $_LOW 揭秘钥匙
       * @return bool TURE 有效 | FALSE 无效
       */
      public static function Auto(string $_UPW, string $_LOW)
      {

         $Auto = substr($_LOW, -3);      //配对值
         $_LOW = substr($_LOW, 0, -3);  // 真实的  解密钥匙
         $_UPW = substr($_UPW, 3);        // 真实的  加密钥匙

         $_LOW = STR::authcode($_LOW, 'unlock', $Auto);

         if (strcmp($_UPW, $_LOW) == 0) {
            return true;
         } else {
            return false;
         }
      }

      /**
       * 加密字符串
       * @param string $_STR 要加密的字符串
       * @param string $_UPW 加密钥匙
       * @return string 加密后的字符串
       */
      public static function UPW(string $_STR, string $_UPW)
      {
         $_UPW = substr($_UPW, 3);        // 真实的  加密钥匙
         return STR::authcode($_STR, 'lock', $_UPW);
      }

      /**
       * 解密字符串
       * @param string $_STR 要解密的字符串
       * @param string $_LOW 解密钥匙
       * @return string 解密后的字符串
       */
      public static function LOW(string $_STR, string $_LOW)
      {
         $Auto = substr($_LOW, -3);      //配对值
         $_LOW = substr($_LOW, 0, -3);   // 真实的  解密钥匙
         $keyLock = STR::authcode($_LOW, 'unlock', $Auto);  //真实的  解密钥匙!!

         $str = STR::authcode($_STR, 'unlock', $keyLock);
         return $str;
      }
   }
}
