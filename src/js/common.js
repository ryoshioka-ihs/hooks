/* Javascript */
/* 切り替え幅 */
var replaceWidth = 768;

$(document).ready(function(){
	//ソースコード内改行による空白を削除
	clearNLSP();

	//ページトップへなめらかスクロール
	setScroll();

	//スマホ版グローバルナビゲーション
	setGnavi();

	//ローディング画像
	scrollTopAfterSendMail();

	// 終了した会社説明会日程を非表示
  hideFinishedDate();
});


//======================================================================================================
// clearNLSP( )
// 機能  ：ソースコード内改行による半角スペースを削除。必ず最初に行うこと。
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function clearNLSP() {
	var list = $("body").html().split("\n");
	var clearflg = true;

	for (var i = 0, j = list.length; i < j; i++) {
		
		//form内の改行は削除しない
		if((list[i].indexOf("<form") != -1) && (list[i].indexOf("</form>") == -1)) {
			clearflg = false;
		}

		if(clearflg) {
			list[i] = list[i].replace(/^\s+|\s+$/g,'').replace(/ +/g,' ');
		}
		else {
			if(list[i].indexOf("</form>") != -1) {
				clearflg = true;
				
				var sptmp = list[i].split("</form>");
				if(sptmp[0] != "") {
					list[i] = "\n" + sptmp[0] + "</form>";
				}
			}
			else {
				list[i] = "\n" + list[i];
			}
		}
	}
	$("body").html(list.join(''));
}

//======================================================================================================
// setScroll( )
// 機能  ：ページトップへの動作設定
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setScroll() {
	var timer = false;
    $(document).bind("scroll", function() {
		if (timer !== false) {
			clearTimeout(timer);
		}
		timer = setTimeout(function() {
			// 対象
			var target = $("#pageTop");
			if ($(window).scrollTop() >= 50) {
				target.fadeIn(500);
			}
			else {
				target.fadeOut(500);
			}

		}, 10);
	});

	//クリックしたらスクロールしてページトップへ
	$('#pageTop').click(function () {
		$('body, html').animate({scrollTop: 0}, 1000);
	});
}

//======================================================================================================
// setGnavi( )
// 機能  ：スマホ表示のハンバーガーメニュー動作設定 及び
//         画面の高さが643px以下になった場合、#policyListのposition: fixed;を解除する動作
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setGnavi() {

	// メニューボタンをクリックした時の動き
	$("body").on("click", "#smtMenu, #closeOv", function(){
		if( parseInt($(window).width()) <= replaceWidth){

			var menu = $('header .menu'), // スライドインするメニューを指定
			menuWidth = menu.outerWidth();

			// body に open クラスを付与する
			$("body").toggleClass('open');
			if($("body").hasClass('open')){
				// open クラスが body についていたらメニューをスライドインする
				$("body").animate({'right' : menuWidth }, 400);           
				menu.animate({'right' : 0 }, 400); 
				
				//クローズ用オーバレイを出力する。
				$("body").append("<div id='closeOv'></div>");
				                  
			} else {
				// open クラスが body についていなかったらスライドアウトする
				menu.animate({'right' : -menuWidth }, 400);
				$("body").animate({'right' : 0 }, 400, function(){
					//クローズ用オーバレイを削除する。
					$("#closeOv").remove();
				});
			}
		}
	});

	//高さ変更時
	function resetPos(){
		if(parseInt($(window).height()) <= 643) {
			$("#policyList").css("position","static");
		}
		else {
			$("#policyList").removeAttr('style');
		}
	}
	$(window).resize(function(){resetPos();});
	resetPos();
}



//======================================================================================================
// scrollTopAfterSendMail()
// 機能  ：フォーム読み込み前にローディング画像を表示
// 引数  ：
// 戻り値：
//======================================================================================================
function scrollTopAfterSendMail() {
	$("#js-googleForm").load(function(){
		$('html,body').animate({ scrollTop: 0 }, 'fast');
		$('.loading').fadeOut();
	});
}

//======================================================================================================
// hideFinishedDate()
// 機能  ：終了した会社説明会日程を非表示
// 引数  ：
// 戻り値：
//======================================================================================================
function hideFinishedDate() {
	$sessions = jQuery('.session .date');
	if ( $sessions.length <= 0 ) {
		return;
	}

	var today = new Date();

	$sessions.each( function() {
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

