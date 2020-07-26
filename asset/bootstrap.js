//$ = global.$ = require('jquery');
import $ from 'jquery';

import './style/base.scss';
import './style/theme/default.scss';
import main from './script/main.js';

$(function(){

  main.init($);
  console.log("bootstrap");

});
