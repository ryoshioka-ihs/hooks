/* Javascript */
$(document).ready(function(){

	//イメージ変更
	changeImg();
});

//======================================================================================================
// changeImg( )
// 機能  ：幅に応じて読み込む画像を変更する
// 引数  ：なし
// 戻り値：なし
//======================================================================================================
function changeImg() {
	var target = $('#main .keyv img'),
	repWidth = 768;

	function imgSize(){
		var winWidth = parseInt($(window).width());
		var flname = target.attr('src');
		
		if( winWidth >= repWidth && flname.indexOf("keyv_smt.png") != -1) {
			target.attr('src',flname.replace("_smt",""));

		} else if(winWidth < repWidth && flname.indexOf("keyv.png") != -1) {
			target.attr('src',flname.replace("keyv.png","keyv_smt.png"));
		}
	}
	$(window).resize(function(){imgSize();});
	imgSize();
}
