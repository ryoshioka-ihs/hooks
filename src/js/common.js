/* Javascript */
/* 切り替え幅 */
var replaceWidth = 768;

$(document).ready(function(){
	//ソースコード内改行による空白を削除
	// clearNLSP();

	//ナビゲーションホバー
	setGnavi();
	
	//スマホ用検索ボタン
	smtSearch();

	//ページトップへなめらかスクロール
	setPageTop();

	//ページ内リンクのなめらかスクロール
	setLinkInPage();

	//疑似チェックボックス動作
	setCkbox();
	
	//ライトボックス
	lightBox();

	//フォームの送信後に画面上部へスクロール
	scrollTopAfterSendMail();

	// PCではtelリンクを無効化
	removeTelLinkOnPC();

 	// セミナー締切日の翌日になったら受付状況「受付終了」に変更（セミナー一覧ページ、セミナー詳細ページ共通）
  	//hideFinishedDateSeminarStop(); 

	// セミナー受付終了日の翌日になったらプルダウンを非表示（セミナーお申込みフォーム）
  	//hideFinishedDateSeminarForm();

	// セミナー開催日の当日になったらプルダウンを非表示（セミナーキャンセルお申込みフォーム）
  	//hideFinishedDateSeminarCancelForm();

 	// セミナー受付終了日の翌日になったら日程削除（セミナー一覧ページ、セミナー詳細ページ共通）
  	hideFinishedDateSeminar(); 


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
// setGnavi( )
// 機能  ：PC表示の場合、グローバルナビのロールオーバー＆ドロップダウンメニュー処理
//         スマホ表示の場合、ハンバーガーメニュー動作
//         PCからスマホに幅が変わった場合、inNavに設定されたスタイルを削除
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setGnavi() {

	// PC ホバー時の処理
	$("#gNav .navWrap > ul > li").hover(

		function(){
			if( parseInt($(window).width()) > replaceWidth){
				if(!$(this).hasClass("act")) {
					$(this).children("a").css('border-bottom-color', '#003E8D');
				}
				$("ul:not(:animated)", this).slideDown();
			}
		},
		function(){
			if( parseInt($(window).width()) > replaceWidth){
				if(!$(this).hasClass("act")) {
	 				$(this).children("a").css('border-bottom-color', '#F9F9F9');
	 			}
				$(".inNav",this).slideUp();
			}
		}
	);

	// メニューボタンをクリックした時の動き
	$("body").on("click", "#gNav #Menu, #gNav #close, #closeOv", function(){

		if( parseInt($(window).width()) <= replaceWidth){

			var menu = $('#gNav .navWrap'), // スライドインするメニューを指定
			body = $(document.body),    
			menuWidth = menu.outerWidth();

			// body に open クラスを付与する
			body.toggleClass('open');
			if(body.hasClass('open')){
				// open クラスが body についていたらメニューをスライドインする
				menu.animate({'right' : 0 }, 400);
				body.append("<div id='closeOv'></div>");

			} else {
				// open クラスが body についていなかったらスライドアウトする
				menu.animate({'right' : -menuWidth }, 400, function(){
					//クローズ用オーバレイを削除する。
					$("#closeOv").remove();
				});
			}
		}
	});

	//幅変更時
	function resetInNav(){
		if(parseInt($(window).width()) <= replaceWidth) {
			$('body, #gNav .navWrap, #gNav .inNav').removeAttr('style');
		}
	}
	$(window).resize(function(){resetInNav();});
	resetInNav();

}

//======================================================================================================
// smtSearch( )
// 機能  ：スマホ表示時、検索ボタンクリックで検索エリアの表示切替を行う
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function smtSearch() {

	var $header = $('.headerMainNav');
	var $form = $('.siteSearch--header .siteSearchForm');

	// 読み込み時のHeaderの高さを保存
	var closeHeight = $header.outerHeight();
	var openHeight = closeHeight + 72;

	$('#scBtn').click( function(){
		$(this).toggleClass('open');

		if($(this).hasClass('open')){
			$header.animate({'height': openHeight + 'px'}, 400);
			$form.fadeIn(800);
		} else {
			$header.animate({'height': closeHeight + 'px'}, 400);
			$form.fadeOut(200);
		}
	});

	$(window).resize(function() {
		closeHeight = $header.outerHeight();
		openHeight = closeHeight + 72;
	});
}

//======================================================================================================
// setPageTop( )
// 機能  ：ページトップへの動作設定
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setPageTop() {

	var timer = false;
    $(document).bind("scroll", function() {

		if (timer !== false) {
			clearTimeout(timer);
		}
		timer = setTimeout(function() {
				// ドキュメントの高さ
				var scrollHeight = $(document).height();
				// ウィンドウの高さ+スクロールした高さ→ 現在のトップからの位置
				var scrollPosition = $(window).height() + $(window).scrollTop();
				// フッターの高さ
				var footHeight = $("footer").height();
				//表示切り替え位置
				var stPoint = $('article').offset().top;
				var target = $('#pageTop');
				 
				// スクロール位置がフッターまで来たら
				if( scrollHeight - scrollPosition  <= footHeight ) {
					// 切り替えバーを固定
					target.fadeIn(500);
					target.addClass("stay");
				}
				else{
					target.removeClass("stay");
					if ($(window).scrollTop() >= stPoint) {
						target.fadeIn(500);
					}
					else {
						target.fadeOut(500);
					}
				}
		}, 10);
	});

	//クリックしたらスクロールしてページトップへ
	$('#pageTop p').click(function () {
		$('body, html').animate({scrollTop: 0}, 1000);
	});
}

//======================================================================================================
// setLinkInPage( )
// 機能  ：ページ内リンクのスクロール速度設定
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setLinkInPage() {
	var $targetLink = $(".linkInPage li a:not([href^='mailto']), .jsSmoothLink a:not([href^='mailto'])");
	if ( $targetLink.size() <= 0 ) {
		return;
	}

	$targetLink.click(function(){
		var speed = 1000;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		
		var position = target.offset().top;
		if(href != "#") {
			position = position - 10;
		}
		
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
}

//======================================================================================================
// setCkbox( )
// 機能  ：擬似チェックボックス初期化および変更時の動作設定を行う
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function setCkbox()
{
	//チェックボックス変更時の動作を設定
    $(".ckBox input").change(function(){
		$(this).parent("label").toggleClass("checked");
    });

	/* チェックボックス＆ラジオボタンの初期化 */
	$('.ckBox input:checked').each(function() {
		$(this).parent("label").addClass("checked");
	});
}

//======================================================================================================
// lightBox( )
// 機能  ：クリックした履歴書または職務経歴書の拡大画像を表示する style="margin-top:-' + height + 'px"
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function lightBox() {
	var body = $("body");

	$(".lightBox p").click(function(){
		var scrollsize = window.innerWidth - $(window).outerWidth(true);
		var imgpath =$(this).prev().find("img").attr('src');
		$("#pageTop").fadeOut(100, function(){
			body.css({"overflow":"hidden", "padding-right":scrollsize + "px" });
			body.append('<div class="overlay"><div class="tbl"><div class="cell"><div class="closeArea"></div><div class="imgCont"><div class="close"></div><img src="'+ imgpath +'"/></div></div></div></div>');
			$(".overlay").fadeIn(500);
		});

	});

	$("body").on("click",".closeArea, .close",function(){
		var target = $(this).parents(".overlay");
		target.fadeOut(function(){
			target.remove();
			body.removeAttr('style');
			$("#pageTop").fadeIn(500);
	   });
	});
}

//======================================================================================================
// fixFormHeight( )
// 機能  ：Googleフォームの送信後、画面上部にスクロールする
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function scrollTopAfterSendMail() {
	$("#js-googleForm").load(function(){
		$('html,body').animate({ scrollTop: 0 }, 'fast');
		$('.loading').fadeOut();
	});
}

//======================================================================================================
//	removeTelLinkOnPC()
// 機能  ：PCではtelリンクを無効化
// 引数  ：
// 戻り値：
//======================================================================================================
function removeTelLinkOnPC() {
	$(function(){
		var ua = navigator.userAgent.toLowerCase();
		var isMobile = /iphone/.test(ua)||/android(.+)?mobile/.test(ua);

		if (!isMobile) {
			$('a[href^="tel:"]').on('click', function(e) {
				return false;
			});
		}
	});
}

//======================================================================================================
// hideFinishedDateSeminar()
// 機能  ：セミナー受付終了日の翌日になったら日程非表示（セミナー一覧ページ、セミナー詳細ページ共通）
// 引数  ：
// 戻り値：
//======================================================================================================
function hideFinishedDateSeminar() {
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




