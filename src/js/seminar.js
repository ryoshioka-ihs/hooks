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
// 機能  ：セミナーに紐づく料金を取得、表示

// 引数  ：
// 戻り値：
//======================================================================================================

function priceset(){
	var courseelement = document.getElementById( "course" ) ;//id="course"の値を取得
	var priceelement = document.getElementById( "price" ) ;//id="price"の値を取得
	priceelement.value = "";

	            		
	if ( courseelement.value == "ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）") {
		// ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）と一致する場合
		priceelement.value="30,000円";
		} else if( courseelement.value == "RPA(WinActor)を学んでさらに飛躍を！研修（3日間）") {
		// IRPA(WinActor)を学んでさらに飛躍を！研修（3日間）と一致する場合
		priceelement.value="10,000円";
		} else if( courseelement.value == "ITパスポート＆EXCEL完全習得＋RPA(WinActor)コース") {
		// ITパスポート＆EXCEL完全習得＋RPA(WinActor)コースと一致する場合
		priceelement.value="35,000円";	
		} else{
		priceelement.value="";
		}    

	changedate();			
}


//======================================================================================================
// 
// 機能  ：セミナーに紐づく料金を取得、表示

// 引数  ：
// 戻り値：
//======================================================================================================

function changedate(){
	var courseelement = document.getElementById( "course" ) ;//id="course"を取得
	var seminarClass = document.getElementById( "seminardate") ;//id="seminardate"を取得
	alert(seminarClass(0).className+"クラス名取得");//id="course"の値を取得、表示
}
	//var seminarelement =  document.getElementById( "seminardate" ).value ;//id="seminarDate"の値を取得
	
	//seminarelement=options.allNoDisplay;

	            		
	/*if ( courseelement.value == "ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）") {
		for (var i = options.length i >= 0;) {
			if (className[i] == "IT"){
				options[i] = allNoDisplay;
			}else{
				options[i] = disabled;
			}
		}
	}*/








		/*// プルダウンの表示リセット
		if ( seminarelement.className != "IT"){ 
			seminarelement=options.allNoDisplay;
			}
		} else if( courseelement.value == "RPA(WinActor)を学んでさらに飛躍を！研修（3日間）") {
		// IRPA(WinActor)を学んでさらに飛躍を！研修（3日間）と一致する場合
		if ( seminarelement.className != "WinActor"){ 
			seminarelement=options.disabled;
			}
		} else if( courseelement.value == "ITパスポート＆EXCEL完全習得＋RPA(WinActor)コース") {
		// ITパスポート＆EXCEL完全習得＋RPA(WinActor)コースと一致する場合
		if ( seminarelement.className != "ITWinActor"){ 
			seminarelement=options.disabled;
			}

		} else{
		priceelement.value="";
		}    		
}






//======================================================================================================
// 
// 機能  ：料金に紐づく日程を表示

// 引数  ：
// 戻り値：
//======================================================================================================
/*	  	const dateAll = 
      	{
        "ITパスポート試験対策＆社会人に必要なEXCEL技術を完全習得研修（10日間）": ["30,000円"],
        "RPA(WinActor)を学んでさらに飛躍を！研修（3日間）": ["10,000円"],
        "ITパスポート＆EXCEL完全習得＋RPA(WinActor)コース": ["35,000円"]
      	};


		function changedate(selectprice){
  			let seminarDate = document.getElementById('seminarDate');
			  seminarDate.disabled = false;
			  seminarDate.innerHTML = '';
			  let option = document.createElement('option');
			  option.innerHTML = '日程を選択してください。';
			  option.defaultSelected = true;
			  option.disabled = true;
			  seminarDate.appendChild(option);  
			  
			  dateAll[selectprice].forEach( menu => {
			    let option = document.createElement('option');
			    option.innerHTML = menu;
			    seminarDate.appendChild(option);  
  			});    
		}
		*/