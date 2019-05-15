"use strict";

function checkForm(){

  var engValue = document.getElementById('eng');
  var jaValue = document.getElementById('ja');
  if(engValue == ""){
    alert("英単語を入力してください");
    return false;
  }else if(jaValue == ""){
    alert("日本語を入力してください");
    return false;
  }else{
    alert("問題ない");
    return true;
  }
}