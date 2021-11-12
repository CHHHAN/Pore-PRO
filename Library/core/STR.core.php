<?php

namespace Core\PORE\Library {

  use Core\PORE\Interfaces\Library;

  //字符串操作类
  class STR implements Library
  {

    public static function _Info()
    {
      return [
        'Library' => 'STR',
        'Dependency' => [''],
        'Author' => 'Prother',
        'README' => '简介链接'
      ];
    }

    //取长度（字节数）
    public static function length($_String)
    {
      return strlen($_String);
    }

    //取长度（字符数）
    public static function long($_String)
    {
      return mb_strlen($_String);
    }

    //字符串是否存在(区分大小写)
    public static function find($_String, $_Find)
    {
      if (strpos($_String, $_Find) == false) {
        return false;
      } else {
        return true;
      }
    }

    //替换（区分大小写）
    public static function ex($_String, $_Find, $_Ex)
    {
      return str_replace($_Find, $_Ex, $_String);
    }

    //分割
    public static function cut($_String, $_Find, $_Number)
    {
      return explode($_String, $_Find, $_Number);
    }

    //删两内容
    public static function delSS($_String, $_Find)
    {
      return trim($_String, $_Find);
    }

    /**
     * 产生随机 code
     * @param int code 位数
     * @return string 返回随机 code
     */
    public static function hitCode($_Number = 9)
    {
      //被随机的 code
      //打乱被随机的code
      //取前9位并返回
      $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $string = str_shuffle($string);
      return substr($string, 0, $_Number);
    }

    /**
     * 加密解密 （Dz的算法）
     * @param string 被加密的字符串
     * @param string 类型，'lock';'unlock'可选
     * @param int 密码
     * @return string 返回 密文/明文 结果
     */
    public static function authcode($_String, $_Type = 'unlock', $_Key = '')
    {
      //有效期
      $expiry = 0;

      // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙 
      $ckey_length = 9;

      // 密匙
      $_Key = md5($_Key != '' ? $_Key : getglobal('authkey'));
      // 密匙a会参与加解密  
      $keya = md5(substr($_Key, 0, 16));
      // 密匙b会用来做数据完整性验证  
      $keyb = md5(substr($_Key, 16, 16));
      // 密匙c用于变化生成的密文  
      $keyc = $ckey_length ? ($_Type == 'unlock' ? substr($_String, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
      // 参与运算的密匙 
      $cryptkey = $keya . md5($keya . $keyc);
      $key_length = strlen($cryptkey);
      // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性  
      // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
      $_String = $_Type == 'unlock' ? base64_decode(substr($_String, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($_String . $keyb), 0, 16) . $_String;
      $string_length = strlen($_String);

      $result = '';
      $box = range(0, 255);

      $rndkey = array();
      // 产生密匙簿  
      for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
      }
      // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
      for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
      }
      // 核心加解密部分  
      for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符  
        $result .= chr(ord($_String[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
      }
      if ($_Type == 'unlock') {
        // substr($result, 0, 10) == 0 验证数据有效性  
        // substr($result, 0, 10) - time() > 0 验证数据有效性  
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性  
        // 验证数据有效性，请看未加密明文的格式 	
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
          return substr($result, 26);
        } else {
          return '';
        }
      } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  	
        return $keyc . str_replace('=', '', base64_encode($result));
      }
    }
  }
}
