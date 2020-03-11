;(function($){
  'use strict';

  var PARAMS = '';

  /**
   * [getUrlVars URLのパラメータを取得する.]
   */
  function getUrlVars(key){
    var param = [], val;
    var params = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < params.length; i++){
      param = params[i].split('=');
      if( key === param[0] ){
        val = param[1];
      }
    }
    return val;
  }


  /**
   * [addParamsToAction formタグののactionにパラメータを追加する.遷移した先でパラメータが落ちないようにするため.]
   */
  function addParamsToAction(){
    var action = $('form').prop('action');

    // パラメータが付与されていない場合にのみパラメータ追加
    if (action.indexOf(PARAMS) == -1) {
      $('form').prop('action', action + PARAMS);
    }
  }

  /**
   * [addParamsToReturnPath リターンパスにパラメータを追加する.遷移した先でパラメータが落ちないようにするため.]
   */
  function addParamsToReturnPath(){
  	var path = $('input[name="return_path"]').val();

    // パラメータが付与されていない場合にのみパラメータ追加
    if (path.indexOf(PARAMS) == -1) {
  	   $('input[name="return_path"]').val(path + PARAMS);
    }
  }


  $(function(){
    var lang_kind = getUrlVars('lang');

    // パラメータがない場合はパラメータを追加しない
    if(lang_kind !== "" && lang_kind !== undefined){
      PARAMS = "?lang=" + lang_kind;
      addParamsToAction();
      addParamsToReturnPath();
    }

  });
})(jQuery);
