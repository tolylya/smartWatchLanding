<?
if($_POST['name']){ // заносим в массив значение полей, их может быть больше
  $znach = array(
    1 => $_POST['name'],
    2 => $_POST['kod'],
    3 => $_POST['tel'],
    4 => $_POST['vremya'],
    5=> $_POST['dopinfo'],
  );
  mail("shonsu@ukr.net", "Заказ Звонка".$_SERVER['HTTP_REFERER'],  
  $znach[1]." ". 
  $znach[2]." ".
  $znach[3]." ".
  $znach[4]." ".
  $znach[5]); // письмо на свой электронный ящик, измените на свой email
}
Header("Refresh: 3; URL=".$_SERVER['HTTP_REFERER']); // спустя 3 секунд человек будет возвращён на предыдущий URL
?>

<!DOCTYPE html>
<title><? print "$znach[1], данные успешно отправлены!"; ?></title>
<meta content='text/html; charset=UTF-8' http-equiv='Content-Type'/>
<meta name="robots" content="noindex"/>
<style>
body {background: #3B5998;}
body > div {
font-family: "Lucida Grande", Tahoma; 
font-size: 11px;
  position: absolute;
  top: 50%; left: 50%;
 -ms-transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%);
text-align: center;
  font-size: 25px;
  color:#3b5998;
  background: #fff;
  border-radius: 10px;
  width:500px;
  padding: 10px 10px 10px 10px ;
}
label:hover {
  color: #dbeaf9;
  cursor: pointer;
}
body > div > div {padding-top: 3%;}
</style>

<div>
<div style="margin-left: 450px; margin-top: -25px;"><label title="Продолжить" >✕</label></div>
<div style="margin-top: -25px;"><? print "$znach[1]"; ?>, Ваша заявка получена!<br>
Мы позвоним Вам в течении часа.</div>
</div>

<script> // нажав на label посетитель вернётся на предыдущую страницу, где заполнял форму
document.getElementsByTagName('label')[0].onclick = function() {
  window.location.href="<? print $_SERVER['HTTP_REFERER']; ?>"
}
</script>