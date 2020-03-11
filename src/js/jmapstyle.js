/* Javascript */

//======================================================================================================
// googleMap表示用Javascript
//======================================================================================================

/*map表示*/
/*
$(function () {

	//アイコンの設置座標を設定
	var latlng = new google.maps.LatLng(35.7057636, 139.760496);

	var myOptions = {
		zoom: 18,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		panControl: false,
		zoomControl: false,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		overviewMapControl: false,
		scrollwheel: false
	};

	var map = new google.maps.Map(document.getElementById('mapCanvas'), myOptions);

	//アイコン設定
	var icon = {
		url : '/image/common/icon_pin.png',
		scaledSize : new google.maps.Size(92,53)
	}

	//アイコンの設置
	var markerOptions = {
		position: latlng,
		map: map,
		icon: icon,
		title: 'IIMヒューマン・ソリューション'
	};

	var marker = new google.maps.Marker(markerOptions);

	//スタイルの変更
	var styleOptions = [{
		"featureType": "all",
		"stylers": [{ "hue": '#0c74ec' }]
	}];

	var changeStyleType = new google.maps.StyledMapType(styleOptions);
	map.mapTypes.set('style', changeStyleType);
	map.setMapTypeId('style');

	//ウィンドウをリサイズしたら再度読み込み
	google.maps.event.addDomListener(window, 'resize', function(){
		map.panTo(latlng);//地図のインスタンス([map]) 
	});

    //クリックしたら指定したurlに遷移するイベント
	google.maps.event.addListener(marker, 'click', function() {
		window.open("https://goo.gl/maps/cozq3bBUvW42" );
	});

});
*/

/*
 * Google Mapを表示
 */
function showGoogleMap(args) {

	args = typeof args !== 'undefined' ? args : [];

	/*本郷地図*/
	/*var opt = {
		map_title:    typeof args.map_title    !== 'undefined' ? args.map_title    : 'IIMヒューマン・ソリューション',
		element_id:   typeof args.element_id   !== 'undefined' ? args.element_id   : 'gmapTopFooter',
		longitude:    typeof args.longitude    !== 'undefined' ? args.longitude    : 35.7057636,
		latitude:     typeof args.latitude     !== 'undefined' ? args.latitude     : 139.760496,
		icon_url:     typeof args.icon_url     !== 'undefined' ? args.icon_url     : '/image/common/icon_pin.png',
		icon_width:   typeof args.icon_width   !== 'undefined' ? args.icon_width   : 92,
		icon_height:  typeof args.icon_height  !== 'undefined' ? args.icon_height  : 53,
		link_map_url: typeof args.link_map_url !== 'undefined' ? args.link_map_url : 'https://goo.gl/maps/cozq3bBUvW42',
	}*/
	/*本郷地図ここまで*/


	/*日比谷地図*/
	var opt = {
		map_title:    typeof args.map_title    !== 'undefined' ? args.map_title    : 'IIMヒューマン・ソリューション',
		element_id:   typeof args.element_id   !== 'undefined' ? args.element_id   : 'gmapTopFooter',
		longitude:    typeof args.longitude    !== 'undefined' ? args.longitude    : 35.671200,
		latitude:     typeof args.latitude     !== 'undefined' ? args.latitude     : 139.757739,
		icon_url:     typeof args.icon_url     !== 'undefined' ? args.icon_url     : '/image/common/icon_pin.png',
		icon_width:   typeof args.icon_width   !== 'undefined' ? args.icon_width   : 92,
		icon_height:  typeof args.icon_height  !== 'undefined' ? args.icon_height  : 53,
		link_map_url: typeof args.link_map_url !== 'undefined' ? args.link_map_url : 'https://goo.gl/maps/Wobx6kgaMM6c64cn6',
	}
	

	/*アイコンの設置座標を設定*/
	var latlng = new google.maps.LatLng(opt.longitude, opt.latitude);
	var gmapOptions = {
		zoom:               typeof args.zoom               !== 'undefined' ? args.zoom               : 18,
		center:             latlng,
		mapTypeId:          google.maps.MapTypeId.ROADMAP,
		panControl:         typeof args.panControl         !== 'undefined' ? args.panControl         : false,
		zoomControl:        typeof args.zoomControl        !== 'undefined' ? args.zoomControl        : false,
		mapTypeControl:     typeof args.mapTypeControl     !== 'undefined' ? args.mapTypeControl     : false,
		scaleControl:       typeof args.scaleControl       !== 'undefined' ? args.scaleControl       : false,
		streetViewControl:  typeof args.streetViewControl  !== 'undefined' ? args.streetViewControl  : false,
		overViewMapControl: typeof args.overViewMapControl !== 'undefined' ? args.overViewMapControl : false,
		scrollwheel:        typeof args.scrollwheel        !== 'undefined' ? args.scrollwheel        : false
	};

	var map = new google.maps.Map(document.getElementById(opt.element_id), gmapOptions);

	// アイコン設定
	var icon = {
		url:        opt.icon_url,
		scaledSize: new google.maps.Size(opt.icon_width, opt.icon_height)
	}

	// アイコンの設置
	var markerOptions = {
		position: latlng,
		map:      map,
		icon:     icon,
		title:    opt.map_title
	};

	var marker = new google.maps.Marker(markerOptions);

	// スタイルの変更
	var styleOptions = [{
		"featureType": "all",
		"stylers": [{ "hue": '#0c74ec' }]
	}];

	var changeStyleType = new google.maps.StyledMapType(styleOptions);
	map.mapTypes.set('style', changeStyleType);
	map.setMapTypeId('style');

	// ウィンドウをリサイズしたら再度読み込み
	google.maps.event.addDomListener(window, 'resize', function(){
		map.panTo(latlng);
	});

	// クリックしたら指定したurlに遷移するイベント
	google.maps.event.addListener(marker, 'click', function() {
		window.open(opt.link_map_url);
	});
}

$(function () {
	// トップページ
	var $gmapTopFooter = $('#gmapTopFooter');
	if ($gmapTopFooter.size() > 0) {
		showGoogleMap();
	}

	// 会社概要東京
	var $gmapAccessTokyo = $('#gmapAccessTokyo');
	if ($gmapAccessTokyo.size() > 0) {
		var args = {
			'element_id': 'gmapAccessTokyo'
		}
		showGoogleMap(args);
	}

	// 会社概要東京（日比谷）
	var $gmapAccessHibiya = $('#gmapAccessHibiya');
	if ($gmapAccessHibiya.size() > 0) {
		var args = {
			'element_id': 'gmapAccessHibiya',
			'longitude': 35.671200,
			'latitude': 139.757739,
			'link_map_url':'https://goo.gl/maps/Wobx6kgaMM6c64cn6'
			
		}
		showGoogleMap(args);
	}
	// 会社概要大阪
	var $gmapAccessOsaka = $('#gmapAccessOsaka');
	if ($gmapAccessOsaka.size() > 0) {
		var args = {
			'element_id': 'gmapAccessOsaka',
			'longitude': 34.710600,
			'latitude': 135.499968,
			'link_map_url':'https://goo.gl/maps/GP4Uh3ATGFJ2'
		}
		showGoogleMap(args);
	}
});

