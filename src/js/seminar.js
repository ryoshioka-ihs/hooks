/* Javascript */
/* 切り替え幅 */
var replaceWidth = 768;

$(document).ready(function(){

 	// セミナー受付終了日の翌日になったら日程削除（セミナー一覧ページ、各セミナーページ）
  	hideFinishedDateSeminar(); 

 	// セミナー締切日の翌日になったら受付状況「受付終了」に変更（セミナー一覧ページ、各セミナーページ）
  	hideFinishedDateSeminarStop(); 

  	//締切日になったら、対象を非表示にするスクリプト（セミナーお申込みフォーム、キャンセルフォーム、お申込みフォームのバナーに設定）
});




//======================================================================================================
// hideFinishedDateSeminar()
// 機能  ：セミナー受付終了日の翌日になったら日程非表示（セミナー一覧ページ、各セミナーページ）

// 引数  ：
// 戻り値：
//======================================================================================================
function hideFinishedDateSeminar() {
	$date = jQuery('.session .date');
	if ( $date.length <= 0 ) {
		return;
	}

	var today = new Date();

	$date.each( function() {
		var date  = $(this).text();
		var match = date.match(/([0-9]{4})年([0-9]{1,2})?月([0-9]{1,2})?日/);
		var year  = match[1];
		var month = Number(match[2]) - 1; /* JSのDateは月を0-11で扱うため調整 */
		var day   = Number(match[3]) + 1; /* 当日の日付まで表示するため調整 */
		var session_date = new Date(year, month, day);

		if (today.getTime() > session_date.getTime()) {
			$(this).closest('tr').hide();
		}
	});
}

//======================================================================================================
// hideFinishedDateSeminarStop()
// 機能  ：セミナー締切日の翌日になったら受付締切日に「受付終了」を表示する（セミナー一覧ページ、各セミナーページ）
// 引数  ：
// 戻り値：
//======================================================================================================*/
function hideFinishedDateSeminarStop() {
	$apply = jQuery('.session .apply');

	if ( $apply.length <= 0 ) {
		return;
	}

	var today = new Date();

	$apply.each( function() {
		var apply  = $(this).text();
		var match = apply.match(/([0-9]{4})年([0-9]{1,2})?月([0-9]{1,2})?日/);
		var year  = match[1];
		var month = Number(match[2]) - 1; // JSのDateは月を0-11で扱うため調整 
		var day   = Number(match[3]) + 1; // 当日の日付まで表示するため調整 
		var session_apply = new Date(year, month, day);
	
		if (today.getTime() > session_apply.getTime()) {
			$(this).closest('td').text('受付終了');			
		}
	});

}

//======================================================================================================
// 
// 機能  ： 締切日になったら、対象を非表示にするスクリプト（セミナーお申込みフォーム、キャンセルフォーム、お申込みフォームのバナーに設定）

// 引数  ：
// 戻り値：
//======================================================================================================
 $(document).ready(function(){
 $(".view_timer").each(function() {
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

//======================================================================================================
// 
// 機能  ：セミナー毎にフィルタリング（セミナー集約ページにて適用、その①）

// 引数  ：
// 戻り値：
//======================================================================================================
function goFilter(){
  var wTable = document.getElementById("allSeminarTable");
  var wSelect = document.getElementById("allSeminarSelect");
  var value  = wSelect.options[wSelect.selectedIndex ].value;  
  if(value == 'all'){
    // --- 全ての場合はクラスをクリア ---
    wTable.className = 'baseSeminar';
  }else{
    // --- タイトル以外のTRを非表示＋指定属性を持つTRのみ表示 ---
    wTable.className = 'allNoDisplay ' + value;
  }
}
          		
 		
//======================================================================================================
// 
// 機能  ：ページを開いたときにＩＴセミナーの日程、料金のみ表示

// 引数  ：
// 戻り値：
//======================================================================================================

/*function openwindow(){

	var seminarDate = document.getElementById( "seminardate") ;//id="seminardate"を取得
	var priceelement = document.getElementById( "price" ) ;//id="price"の値を取得
	// 初期化
    for (var i = 0; i < seminarDate.length; i++){
       seminarDate.options[i].disabled = true;//trueで日程を非表示でリセットする、後続はfalseで表示させる
    }
    priceelement.value="30,000円";
	seminarDate.options[1].disabled = false;
	seminarDate.options[2].disabled = false;

}
*/

//======================================================================================================
// 
// 機能  ：セミナーに紐づく料金を表示する。セミナー名に紐づく日程の選択制御。

// 引数  ：
// 戻り値：
//======================================================================================================

/*function priceset(){
	var courseelement = document.getElementById( "course" ) ;//id="course"の値を取得
	var priceelement = document.getElementById( "price" ) ;//id="price"の値を取得
	priceelement.value = "";

	var seminarDate = document.getElementById( "seminardate") ;//id="seminardate"を取得
	// 初期化
    for (var i = 0; i < seminarDate.length; i++){
       seminarDate.options[i].disabled = true;//trueで日程を非表示でリセットする、後続はfalseで表示させる
    }
	            		
	if ( courseelement.value == "ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）") {
		// ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）と一致する場合
			priceelement.value="30,000円";
			seminarDate.options[1].disabled = false;
    		seminarDate.options[2].disabled = false;
		} else if( courseelement.value == "RPA(WinActor)を学んでさらに飛躍を！研修（3日間）") {
		// IRPA(WinActor)を学んでさらに飛躍を！研修（3日間）と一致する場合
			priceelement.value="10,000円";
			seminarDate.options[3].disabled = false;
    		seminarDate.options[4].disabled = false;
		} else if( courseelement.value == "【セットコース】ITパスポート＆EXCEL完全習得＋RPA(WinActor)（13日間）") {
		// ITパスポート＆EXCEL完全習得＋RPA(WinActor)コースと一致する場合
			priceelement.value="35,000円";
			seminarDate.options[5].disabled = false;
    		seminarDate.options[6].disabled = false;	
		} else{
			priceelement.value="";
		}    
		
}*/

//======================================================================================================
// 
// 機能  ：Microsoft 365セミナー日程表示/非表示

// 引数  ：
// 戻り値：
//======================================================================================================
function showdate () {
var courseelement = document.getElementById( "course" ) ;//id="course"の値を取得
var seminarDate = document.getElementById( "seminardate") ;//id="seminardate"を取得

  for (var i = 0; i < seminarDate.length; i++){
       seminarDate.options[i].disabled = true;
  }
	// disabledに代入
     if ( courseelement.value == "【MS365】PowerAutomateを使用した申請業務") {
	   seminarDate.options[1].disabled = false;
     } else if ( courseelement.value == "【MS365】PowerShellを利用したユーザアカウント管理方法") {
	   seminarDate.options[2].disabled = false;
     } else if ( courseelement.value == "【MS365】Azureでのチャットボット機能の構築") {
	   seminarDate.options[3].disabled = false;
     } else if ( courseelement.value == "【MS365】PowerAutomateを使用した日報作成 (条件分岐の設定方法）") {
	   seminarDate.options[3].disabled = false;
  }
}
