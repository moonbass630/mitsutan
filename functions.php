<?php
/*
 Plugin Name: mitsutan
 Plugin URI: https://mitsublo.com
 Description: 英単語を勉強できる
 Author: Mitsuki
 Version: 1.0
 Author URI: https://mitsublo.com
 License: MIT
*/
//「Plugin URI」ではそのプラグインの詳細が書かれているページのURLを載せることができる
//「Author URI」ではそのプラグインの作成者の詳細が書かれているページのURLを載せることができる
//今回は自分のホームページに飛ぶようにしている


//フックで関数を呼び出すようにする。
//admin_menu()が呼び出された時にwpdocs_register_my_custom_menu_page()が呼び出されるようにする。
add_action( 'admin_menu', function(){
    add_menu_page(
      'みつタン設定画面',         //メニュー選択した後に表示されるページの名前
      'みつタン',         //管理画面上に表示される名称
      'manage_options',  //表示するユーザの権限
      'mitsutan',      //管理するスラッグ
      'mtt_getConfigPage',  //呼び出す関数名
      'dashicons-book-alt',//ダッシュアイコンのURL（本）
      21                //メニュー位置
    );
});

function mtt_getConfigPage(){

  // //入力フォームから値を取ってくる
  // $sWordValue = $_POST['content'];

  $html = '';

  $html .= '<h2>みつタン</h2>';
  $html .= '<form action="" method="POST" name="regform">';//"action"はpostの送信先。空だとformがあるファイルにpostの内容を送る

  //保存ボタンが押下された時のみテキストファイルを作成し、単語を登録する
  if(isset($_POST['save'])){
    //入力フォームから値を取得  
    $aEngWords = $_POST['eng'];
    $aJaWords = $_POST['ja'];
    //英単語=>日本語の連想配列を作成
    $aaWords = array_combine($aEngWords, $aJaWords);
    //キーが空の要素を削除する
    unset($aaWords[null]);
    //Json形式に変換する
    $json = json_encode($aaWords);
    //テキストファイルを作成する
    file_put_contents(mtt_getFilePath().mtt_getFileName(), $json);
  }

  //Jsonファイルの内容を取得する
  $sWordValue = file_get_contents(mtt_getFilePath().mtt_getFileName());
  //Jsonファイルの内容をデコードして連想配列を格納する
  $aaJsonImported = json_decode($sWordValue, 'ture');

  //連想配列の数だけループして入力フォームを表示させるようにする
  foreach($aaJsonImported as $key=>$value){
    $html .= "<input type='text' id='eng' name='eng[]' value=$key>";
    $html .= "<input type='text' id='ja' name='ja[]' value=$value>";
    $html .= '<br>';
  }
  //一つ多めに入力フォームを表示させる
  $html .= '<input type="text" id="eng" name="eng[]" value="">';
  $html .= '<input type="text" id="ja" name="ja[]" value="">' ;

  $html .= '<input type="submit" value="保存" name="save" onclick="checkForm()">';
  $html .= '</form>';

  //HTMLをprintする
  print $html;
}



//入力フォームの値を取ってくる関数
function mtt_getWordValue(){
  $sWordValue = $_POST['content'];
  return $sWordValue;
}

function mtt_getFilePath(){
  $sPath = "/home/moonbass/www/wp/wp-content/plugins/mitsutan/";
  return $sPath;
}

function mtt_getFileName(){
  $sFileName = "saved_word.txt";
  return $sFileName;
}

//javaScriptとCSSのファイルを読み込む
add_action('admin_enqueue_scripts', function(){
  wp_enqueue_script(
    'mitsu-common',//キューを登録する、”common”はいろんなところで使われる名前だから危険
    plugins_url('js/common.js', __FILE__),
    array(),
    false,
    true
  ); 
  wp_enqueue_style(
    'mitsu-stylesheet',//キューを登録する、”common”はいろんなところで使われる名前だから危険
    plugins_url('css/stylesheet.css', __FILE__)
  );
});



