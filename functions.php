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
      'dashicons-book-alt',//ダッシュアイコンのURL（ニンジン）
      21                //メニュー位置
    );
});

function mtt_getConfigPage(){
  print "fromみつタン";
}

//javaScriptを読み込む
add_action('admin_enqueue_scripts', function(){
  wp_enqueue_script(
    'mitsu-common',//キューを登録する、”common”はいろんなところで使われる名前だから危険
    plugins_url('js/common.js', __FILE__),
    array(),
    false,
    true
  );
});

//CSSを読み込む
add_action('admin_enqueue_style', function(){
  wp_enqueue_style(
    'mitsu-stylesheet',//キューを登録する、”common”はいろんなところで使われる名前だから危険
    plugins_url('css/stylesheet.css', __FILE__),
    array(),
    false,
    null
  );
});

