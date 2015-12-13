<?
function get_data($smtp_conn)
{
    $data="";
    while($str = fgets($smtp_conn,515))
    {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    }
    return $data;
}

$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
$header.="From: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('sdkwatch')))."?= <admin@sdkwatch.ru>\r\n";
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
$header.="Reply-To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('sdkwatch')))."?= <admin@sdkwatch.ru>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
$header.="To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Анатолий')))."?= <tolylya220@gmail.com>\r\n";
$header.="Subject: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Заказ часов sdkwatch')))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: text/plain; charset=UTF-8\r\n";
$header.="Content-Transfer-Encoding: 8bit\r\n";

$znach = array(
    1 => $_POST['name']
  );

$text = "Имя: ".$_POST['name']." | Телефон: ". $_POST['tel']." | Тип часов: ". $_POST['watch'];

$smtp_conn = fsockopen("n2.hosting.energy", 25,$errno, $errstr, 10);
if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); exit;}
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO vasya\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); exit;}
fputs($smtp_conn,"AUTH LOGIN\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); exit;}

fputs($smtp_conn,base64_encode("admin@sdkwatch.ru")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); exit;}

fputs($smtp_conn,base64_encode("M5cCFp6E")."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "не правильный пароль"; fclose($smtp_conn); exit;}

$size_msg=strlen($header."\r\n".$text);

fputs($smtp_conn,"MAIL FROM:<admin@sdkwatch.ru> SIZE=".$size_msg."\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"RCPT TO:<tolylya220@gmail.com>\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"DATA\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); exit;}

fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "ошибка отправки письма"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"QUIT\r\n");
fclose($smtp_conn);

Header("Refresh: 3; URL=".$_SERVER['HTTP_REFERER']);

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
