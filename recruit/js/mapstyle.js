function initialize() {
  var latlng = new google.maps.LatLng(35.705947,139.760465);
  var myOptions = {
    zoom: 18, /*拡大比率*/
    center: latlng, /*表示枠内の中心点*/
    mapTypeId: google.maps.MapTypeId.ROADMAP/*表示タイプの指定*/
  };
  var map = new google.maps.Map(document.getElementById('map_canvas01'), myOptions);
  /*アイコン設定▼*/
  var icon = new google.maps.MarkerImage('/recruit/image/info/mapLogoTokyo.png',
    new google.maps.Size(100,72),/*アイコンサイズ設定*/
    new google.maps.Point(0,0)/*アイコン位置設定*/
    );
  var markerOptions = {
    position: latlng,
    map: map,
    icon: icon,
    title: 'IIMヒューマン・ソリューション株式会社 東京本社'
  };
  var marker = new google.maps.Marker(markerOptions);
  var latlng = new google.maps.LatLng(34.710835,135.499917);
  var myOptions = {
    zoom: 18, /*拡大比率*/
    center: latlng, /*表示枠内の中心点*/
    mapTypeId: google.maps.MapTypeId.ROADMAP/*表示タイプの指定*/
  };
  var map = new google.maps.Map(document.getElementById('map_canvas02'), myOptions);
  /*アイコン設定▼*/
  var icon = new google.maps.MarkerImage('/recruit/image/info/mapLogoOsaka.png',
    new google.maps.Size(100,72),/*アイコンサイズ設定*/
    new google.maps.Point(0,0)/*アイコン位置設定*/
    );
  var markerOptions = {
    position: latlng,
    map: map,
    icon: icon,
    title: 'IIMヒューマン・ソリューション株式会社 大阪支店'
  };
  var marker = new google.maps.Marker(markerOptions);
}
