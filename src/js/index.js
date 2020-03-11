/* Javascript */
$(document).ready(function(){
	//スライダー
	keyvSlider();
	
	//タブ表示切替処理
	tabSelect();

	//タブの表示スタイルリセット
	resetStyle();

});

//======================================================================================================
// keyvSlider( )
// 機能  ：キービジュアルのスライダー設定
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function keyvSlider(){
	$('#keyv .kvList').slick({
		// アクセシビリティ。左右ボタンで画像の切り替えをできるかどうか
		accessibility: true,
		// 自動再生。trueで自動再生される。
		autoplay: true,
		// 自動再生で切り替えをする時間
		autoplaySpeed: 5000,
		// 自動再生や左右の矢印でスライドするスピード
		speed: 500,
		// 自動再生時にスライドのエリアにマウスオンで一時停止するかどうか
		pauseOnHover: true,
		// 自動再生時にドットにマウスオンで一時停止するかどうか
		pauseOnDotsHover: true,
		// 切り替えのアニメーション。ease,linear,ease-in,ease-out,ease-in-out
		cssEase: 'ease',
		// 画像下のドット（ページ送り）を表示
		dots: true
	
	});
}

//======================================================================================================
// tabSelect( )
// 機能  ：タブ表示切替処理
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function tabSelect() {
	//クリック時動作
	$("#tab li").click(function() {
		
		/* pcの場合はタブ切り替え表示 */
		if( parseInt($(window).width()) > 768 && !$(this).hasClass("act") ){
			changeList($(this));
		}
		else {
			//スマホの場合はアコーディオン
			if(!$(this).hasClass("act") ){
				changeList($(this));
				$("#tab li").not(".act").slideUp();
			}
			else {
				$("#tab li").slideDown();
			}
		}
	});

	// 表示切替関数
	function changeList(target) {
		//.index()を使いクリックされたタブが何番目かを調べ、
		//indexという変数に代入します。
		var index = $('#tab li').index(target);

		//コンテンツを一度すべて非表示にし、
		$('#tabCont > ul').hide();

		//クリックされたタブと同じ順番のコンテンツを表示します。
		$('#tabCont > ul').eq(index).fadeToggle();

		//一度タブについているクラスactを消し、
		$('#tab li').removeClass('act');

		//クリックされたタブのみにクラスactをつけます。
		target.addClass('act');
	}
}

//======================================================================================================
// resetStyle( )
// 機能  ：スマートフォン表示からPC表示に切り替わった場合、スマホ表示用スタイルを取り除く
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function resetStyle() {

	function resetTab(){
		if(parseInt($(window).width()) > 768) {
			$('#tab li').removeAttr('style');
		}
	}
	$(window).resize(function(){resetTab();});
	resetTab();
}
