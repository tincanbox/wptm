<?php

# If you want to use WPTM as an extension, move this part to your bootstrap-file like 'functions.php'.
# Or move `themes/wptm/app` to `plugin/wptm`.
include_once dirname(__FILE__).'/app/bootstrap.php';

# Sometimes, emoji related action/filter(s) occures 'Use of undefined constant' error.
!defined('SCRIPT_DEBUG') && define('SCRIPT_DEBUG', true);
