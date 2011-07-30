<?php

if ( ! defined('PERSSONAL_VERSION'))
{
  define('PERSSONAL_VERSION', '0.4');
  define('PERSSONAL_NAME', 'Perssonal');
  define('PERSSONAL_DESCRIPTION', 'Feeds the needs... the needs for feeds.');  
  define('PERSSONAL_DOCUMENTATION', 'http://www.baseworks.nl/software/perssonal');
  
  define('PERSSONAL_HAS_CP', 'n');
  define('PERSSONAL_HAS_PUBLISH', 'n');
}

$config['name'] = PERSSONAL_NAME;
$config['version'] = PERSSONAL_VERSION;
$config['description'] = PERSSONAL_DESCRIPTION;
$config['nsm_addon_updater']['versions_xml'] = '';