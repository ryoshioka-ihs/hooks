$(function(){
  //来場認証画面で、インプット要素からフォーカスが外れた場合、警告文を表示する.
  //フォーカスされた場合は警告文を消す.
  //サブミット時にも警告文が表示される問題の改善のため作成
  //フォーカスされた場合の処理
  $('input[type="text"],input[type="submit"]').focus(function() {
    /* Act on the event */
    $('#input_alert').addClass('hidden');
    $('#input_alert').removeClass('visible');
    $('#input_alert').removeClass('alert');
  });
  //フォーカスが外れた場合の処理
  $('input[type="text"],input[type="submit"]').blur(function() {
    $('#input_alert').removeClass('hidden');
    $('#input_alert').addClass('alert');
    $('#input_alert').addClass('visible');
  });
});
