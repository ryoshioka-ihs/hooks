;(function($, undefined) {

  var smpMargeUtl = window.smpMargeUtl = {};

  /* Group Action */
  // check_dmflg_disable が trueの場合は、過去に一度でもDMフラグ不許可があると強制的に不許可になる
  smpMargeUtl.check_dmflg_disable = false;

  // グループとして扱うセレクターのnameをCSSセレクタ形式で保存
  // setGroupNamesのインターフェースを利用する
  smpMargeUtl.group_name_selectors = [];

  /**
   * グループとして扱うnameを指定する
   * @param {Array.<string>} arr グループとして扱うnameを指定する
   * @return {void}
   */
  smpMargeUtl.setGroupNames = function(arr) {
    smpMargeUtl.group_name_selectors = [];

    for (var i = 0, l = arr.length; i < l; i++) {
      smpMargeUtl.group_name_selectors.push('[name="' + arr[i] + '"]');
    }
  };


  /**
   *  特定の項目のみ指定された番号で強制的に上書きをする
   *  空白であっても最新を採用したい場合などに利用
   *  @param {Array.<string>} names 対象となるnameを配列で指定
   *  @param {number} [index=0] 上書きした項目番号初期値は0
   */
  smpMargeUtl.overCheck = function(names, index) {
    var idx = index || 0;

    for (var i = 0, l = names.length; i < l; i++) {
      $('[name="' + names[i] + '"]').eq(idx).attr("checked", "checked");
    }
  };

  /**
   * 指定されたセレクターがマージの何番目の順番か調べる
   * @param {string} selector 調査する要素のCSSセレクタ
   * @return {number || null}
   */
  smpMargeUtl.getGroupSelectedIndex = function(selector) {
    var index = 0;
    var $input = $(selector);

    if (!smpMargeUtl.hasInput($input)) {
      return null;
    }

    $input.each(function(i) {
      if (!!$(this).attr("checked")) {
        index = i;
      }
    });

    return index;
  };

  /**
   * 指定された番号のグループをまとめてチェックをつける
   * @param {number} index グループとして扱いたいマージ順の番号
   * @return {void}
   */
  smpMargeUtl.checkGroupInput = function(index) {
    $.each(smpMargeUtl.group_name_selectors, function(i, selector) {
      $(selector).eq(index).attr('checked', 'checked');
    });
  };

  /**
   * グループのチェックを実行
   * メソッド名が正直微妙 selectじゃないし・・・・
   * @return {void}
   */
  smpMargeUtl.selectGroups = function() {
    var select_index = 10;

    $.each(smpMargeUtl.group_name_selectors, function(i, v) {
      var selected_index = smpMargeUtl.getGroupSelectedIndex(v);
      if (selected_index === null) {
        return true;
      }

      if (selected_index < select_index) {
        select_index = selected_index;
      }
    });

    if (select_index === 10) return;
    smpMargeUtl.checkGroupInput(select_index);
  };

  /**
   *  SMPの検索は部分一致のため完全一致をJavaScriptで実装
   *  todo: nameから親をたどってラベル名を取得したら順番などの指定は不要になる……が社内用なので優先順位低
   *  @param {Object.<string, number>} settings チェックしたいnameとtdの順番が格納されたオブジェクト
   *  @return {void}
   */
  smpMargeUtl.strictCheck= function(settings) {
    var $list_row = $('.list .listRow');

    $('[name="btn_merger_single"]')
    .removeAttr('onclick')
    .click(function() {

      // input reset
      $list_row.find('input').attr('checked', false);

      var cnt = 0;
      $list_row.each(function() {
        var $tr = $(this);
        var check_flg = true;

        $.each(settings, function(k, v) {

          var input_str = $.trim($('[name="' + k + '"]').val().toLowerCase());
          var td_str = $.trim($tr.find('td').eq(v).text().toLowerCase());

          if (input_str !== td_str) {
            check_flg = false;
          }
        });

        if (check_flg && cnt < 10) {
          $tr.find('input').attr('checked', true);
          cnt++;
        }
        submitMergerSingle(document.forms[0]);
      });
    });
  };

  /**
   *  マージ画面か確認
   *  @param {string} check_url マージのURLを指定(固定でもよいか？)
   *  @param {string} [now_location=location.href] location.href
   *  @return {boolean}
   */
  smpMargeUtl.isMatchUrl = function(check_url, now_location) {
    now_location = now_location || location.href;
    return !!now_location.match(check_url);
  };


  /**
   *  jqueryオブジェクトの有無確認
   *  @param {jQuery} $input 調査するjQueryオブジェクト
   *  @return {boolean}
   */
  smpMargeUtl.hasInput = function($input) {
    return $input.length > 0;
  };

  /**
   *  指定されたjQueryオブジェクトの親の中に含まれるテキストのチェック
   *  hasTextとなっているが完全一致で検証。要名称変更
   *  @param {jQuery} $input チェックするjQueryオブジェクト。実際はこれの親からテキストを拾う
   *  @param {string} key 比較するテキスト 要名称変更
   *  @return {boolean}
   */
  smpMargeUtl.hasText = function($input, key) {
    var $parent = $input.parent();
    var $paretn_string = $.trim($parent.text());

    return encodeURI($paretn_string) === key;
  };

  /**
   * DMフラグが過去に一回でも無効になっていれば無効を採用する
   * @return {void}
   */
  smpMargeUtl.dmflgDisable = function() {
    $("[name='permission_type_master_id_select']").each(function() {
      var $this = $(this);
      if (!!smpMargeUtl.hasText($this, "%E5%B8%8C%E6%9C%9B%E3%81%97%E3%81%AA%E3%81%84")) {
        $this.attr("checked", "checked");
        return false;
      }
    });
  };

  /**
   * マージする時にチェックすべき対象をチェック
   * 左(更新日の新しいもの)から順番にチェックして、
   * それの値が空白なら次に値が入っている物を探す
   * @param {jQuery} $inputs チェックするjQueryオブジェクト
   * @return {jQuery} jQueryオブジェクトを生で返す。
   */
  smpMargeUtl.getCheckTarget = function($inputs) {
    var $target = $inputs.eq(0);

    $inputs.each(function() {
      var $this = $(this);

      if (!smpMargeUtl.hasText($this, "")) {
        $target = $this;
        return false;
      }
    });

    return $target;
  };

  /**
   *  マージのためのチェックを実行する
   *  @return {void}
   */
  smpMargeUtl.selectValue = function() {
    var $record = $('#ep .detailList tr');

    $record.each(function() {
      var $this = $(this);
      var $inputs = $this.find("input");

      var $target;

      if (!smpMargeUtl.hasInput($inputs)) return true;

      $target = smpMargeUtl.getCheckTarget($inputs);
      $target.attr("checked", "checked");
    });

    if (!!smpMargeUtl.check_dmflg_disable) {
      smpMargeUtl.dmflgDisable();
    }
  };
}(jQuery));
