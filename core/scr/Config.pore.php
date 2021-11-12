<?php

namespace Core\PORE {

  class Config
  {

    public static $configPath;
    public static $Config;

    public static $PORE, $RUNNING, $PACKAGE;

    public function __construct()
    {
      self::$Config = json_decode(file_get_contents(ROOT_PATH . Config::$configPath), true);
      self::$PORE = self::$Config['PORE'];
      self::$RUNNING = self::$Config['RUNNING'];
      self::$PACKAGE = self::$Config['PACKAGE'];
    }
  }
}