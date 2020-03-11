;(function(){
  'use strict';

  /**
   * [addSubmitBtn JSでボタンを追加する.JSが無効の場合は次へ進めないようにする対策.]
   */
  function addSubmitBtn(){
    var btn = smp$form.js_submit_btn;
    $('.js_btn_area').append(btn);
  }

  $(function(){
    addSubmitBtn();
  });
})(jQuery);
