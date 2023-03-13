<?php

  // Load Config
  require_once 'config/config.php';

  // Load Helpers
  require_once 'helpers/headerHelper.php';
  require_once 'helpers/postHelper.php';
  require_once 'helpers/getHelper.php';
  require_once 'helpers/requestMethod.php';

  // Autoload Core Classes
  spl_autoload_register(function($className){
    require_once 'core/' . $className . '.php';
  });
  
