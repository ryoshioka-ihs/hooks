/* Javascript */
/* 切り替え幅 */
var replaceWidth = 768;


//======================================================================================================
// 
// 機能  ：セミナー受付終了日の翌日になったらプルダウンを非表示（セミナーお申込みフォーム）

// 引数  ：
// 戻り値：
//======================================================================================================
$(document).ready(function() {
  $(".info_view_timer").each(function() {
    var startDate = $(this).attr("data-start-date");
    var endDate = $(this).attr("data-end-date");
    var nowDate = new Date();
    if (startDate) {
      startDate = new Date(startDate);
    } else {
      startDate = nowDate;
    }
    if (endDate) {
      endDate = new Date(endDate);
    }
    if (startDate <= nowDate && (!endDate || nowDate <= endDate)) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});
