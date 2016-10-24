<?
include 'lb.php';
include 'lang.php';
include 'forminput.php';

if (isset($usehttps)&&$usehttps) include 'https.php'; 
include 'connect.php';
include 'auth.php';
include 'xss.php';


$csrfkey=sha1($salt.'csrf'.$_SERVER['REMOTE_ADDR'].date('Y-m-j-g'));
$csrfkey2=sha1($salt.'csrf'.$_SERVER['REMOTE_ADDR'].date('Y-m-j-g',time()-3600));

$error_message='';

$passreset=0;

if (isset($_POST['lang'])&&in_array($_POST['lang'],array_keys($langs))) {
	$lang=$_POST['lang'];include 'lang/dict.'.$lang.'.php';  
	setcookie('userlang',$_POST['lang'],time()+3600*24*30*6); //keep for 6 months
}

if ( (isset($_POST['password'])&&$_POST['password']) || (isset($_POST['login'])&&$_POST['login']) ){	
	
	xsscheck();

	$cfk=$_POST['cfk'];
	if ($cfk!=$csrfkey&&$cfk!=$csrfkey2){
	
		$error_message=_tr('csrf_expire');
	} else {
	
		$password=md5($dbsalt.$_POST['password']);
		$raw_login=$_POST['login'];
		$login=str_replace("'",'',$raw_login);
		
		$query="select * from ".TABLENAME_USERS." where login='$login' and active=1 and virtualuser=0";
		$rs=sql_query($query,$db);  
		
		$passok=0;
		
		if ($myrow=sql_fetch_array($rs)){
			$enc=$myrow['password'];
			$dec=decstr($enc,$dbsalt);
			if ($password==$dec) $passok=1;
		}
		
		if ($passok){
			
			$userid=$myrow['userid'];
			$passreset=$myrow['passreset'];
			
			$needcert=$myrow['needcert'];
			$certid=$_POST['certid'];
			$certhash=md5($dbsalt.$certid);
			$certhash_=$myrow['certhash'];
			
			$dispname=$myrow['dispname'];
			
			$certokay=1;
			
			if ($needcert){
				if ($certhash!=$certhash_){
					$certerror='Invalid ID card';
					$certokay=0;
				}
				if ($certid=='') {
					$certerror='A smart card is required to sign in';
					$certokay=0;
				}
			}
			
			if (isset($_POST['passreset'])&&$_POST['passreset']){
				$op=md5($dbsalt.$_POST['password']);
				$np=$_POST['newpassword'];
				$np2=$_POST['newpassword2'];
				if ($np!=$np2||$op==$np||trim($np)==''){
					if ($np==$op) $error_message=_tr('new_password_must_be_different');
					if ($np!=$np2) $error_message=_tr('mismatching_password');
					if (trim($np)=='') $error_message=_tr('must_provide_new_password');
				} else {
					$newpass=encstr(md5($dbsalt.$np),$dbsalt);
					$query="update users set password='$newpass', passreset=0 where userid=$userid";
					sql_query($query,$db);
					$passreset=0;	
				}	  
			}
			  	  	  
			if ($passreset){
			
			} else {
				if ($certokay){	  
					$groupnames=$myrow['groupnames'];
					$auth=md5($salt.$userid.$groupnames.$salt.$raw_login.$salt.$dispname);
					
					setcookie('auth',$auth);
					setcookie('userid',$userid);
					setcookie('login',$login);
					setcookie('dispname',$dispname);
					setcookie('groupnames',$groupnames);
					
					if (isset($_POST['lang'])){
						if (!in_array($_POST['lang'],array_keys($langs))) $_POST['lang']=$deflang;
						setcookie('userlang',$_POST['lang'],time()+3600*24*30*6); //keep for 6 months
					}
					
					if (isset($_GET['from'])&&trim($_GET['from'])!='') {
					  $from=$_GET['from'];
					  $from=str_replace('://','',$from);
					  $from=str_replace("\r",'-',$from);
					  $from=str_replace("\n",'-',$from);
					  $from=str_replace(":",'-',$from);
					  header('Location: '.$from);
					} else header('Location:index.php');
					die();
				} else {
					$error_message=$certerror;
				}//certokay
			}//passreset
		} else $error_message=_tr('invalid_password'); //passcheck
	
	}//csrf
	
} else {
	setcookie('userid',NULL,time()-3600);
	setcookie('login',NULL,time()-3600);
	setcookie('dispname',NULL,time()-3600);
	setcookie('auth',NULL,time()-3600);
	setcookie('groupnames',NULL,time()-3600);	
}

?>
<html>
<head>
	<title><?echo GYROSCOPE_PROJECT;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="1800" />
	<meta name = "viewport" content = "width=device-width, user-scalable=no" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<?include 'appicon.php';?>
	
<style>
body{padding:0;margin:0;background:transparent url(imgs/bgtile.png) repeat;font-size:13px;font-family:arial,sans-serif;text-align:center;}
#loginbox__{width:320px;margin:0 auto;background-color:rgba(200,200,200,0.4);margin-top:100px;border-radius:4px;}
#loginbox_{padding:10px;}
#loginbox{background-color:#FFFFFF;text-align:left;}
.powered{color:#000000;text-align:right;font-size:12px;width:320px;margin:0 auto;padding-top:10px;}
#loginbutton{width:140px;-webkit-appearance: none;}
#cardlink, #passlink{display:none;text-align:center;padding-top:10px;}
#cardlink{display:none;}
#cardinfo{padding:5px;font-size:12px;padding-left:26px;background:#fcfcdd url(imgs/smartcard.png) no-repeat 5px 50%;margin-bottom:10px;display:none;}

@media screen and (max-width:400px){
	#loginbox__,.powered{width:90%;}
	#loginbox__{margin-top:50px;}
}

@media screen and (max-width:300px){
	#loginbutton{width:auto;padding-left:5px;padding-right:5px;}
}

@media screen and (max-width:260px){
	.powered{text-align:center;}
	.powered span{display:block;padding-top:3px;}
}
</style>
</head>
<body>
<div id="loginbox__"><div id="loginbox_">
<div id="loginbox">
	<form method="POST" style="padding:20px;margin:0;padding-top:10px;" onsubmit="return checkform();">
	<img src="imgs/logo.png" style="margin:10px 0;width:100%;">
	<?if ($error_message!=''){?>
	<div style="color:#ab0200;font-weight:bold;padding-top:10px;"><?echo $error_message;?></div>
	<?}?>
	
	<div style="padding-top:10px;"><?tr('username');?>: <?if ($passreset){?><b><?echo stripslashes($_POST['login']);?></b> &nbsp; <a href="<?echo $_SERVER['PHP_SELF'];?>"><em><?tr('switch_user');?></em></a><?}?></div>
	<div style="padding-top:5px;padding-bottom:10px;">
	<input style="width:100%;<?if ($passreset) echo 'display:none;';?>" id="login" type="text" name="login" autocomplete="off" <?if ($passreset) echo 'readonly';?> value="<?if ($passreset) echo stripslashes($_POST['login']);?>"></div>

	<div id="passview">
		<div><?tr('password');?>:</div>
		<div style="padding-top:5px;padding-bottom:15px;">
		<input style="width:100%;" id="password" type="password" name="password"></div>
	

	<?if ($passreset){?>
	<div><?tr('new_password');?>:</div>
	<div style="padding-top:5px;padding-bottom:15px;">
	<input style="width:100%;" id="password" type="password" name="newpassword"></div>
		
	<div><?tr('repeat_password');?>:</div>
	<div style="padding-top:5px;padding-bottom:15px;">
	<input style="width:100%;" id="password" type="password" name="newpassword2"></div>
	<input type="hidden" name="passreset" value="1">
	<?}?>

	<div style="width:100%;margin-bottom:10px;<?if (count($langs)<2) echo 'display:none;';?>"><select style="width:100%;" name="lang" onchange="document.skipcheck=true;">
	<?
	foreach ($langs as $langkey=>$label){
	?>
	<option value="<?echo $langkey;?>" <?if ($lang==$langkey) echo 'selected';?>><?echo $label;?></option>
	<?	
	}//foreach
	?>
	</select>
	</div>
	
	<div id="cardinfo"></div>
	
		<div  style="text-align:center;"><input id="loginbutton" type="submit" value="<?echo $passreset?_tr('change_password'):_tr('signin');?>"></div>
		<div id="cardlink">
			<a href=# onclick="cardauth();return false;">Load ID Card</a>
		</div>
	</div><!-- passview -->
	<div id="cardview" style="display:none;">
		<div style="text-align:center;"><input id="loginbutton" type="submit" value="<?tr('signin');?>" onclick="if (!cardauth()) return false;"></div>
		<div id="passlink">
			<a href=# onclick="passview();return false;">Sign in with password</a>
		</div>
	</div>
	<input name="cfk" value="<?echo $csrfkey;?>" type="hidden">
	<div style="display:none;"><textarea name="certid" id="certid"></textarea></div>
	</form>
	&nbsp;
</div>
</div></div>	
	<?
	$version=GYROSCOPE_VERSION;
	if (VENDOR_VERSION!='') $version.=VENDOR_VERSION;
	if (VENDOR_NAME) $version.=' '.VENDOR_NAME;
	$power='Antradar Gyroscope&trade; '.$version;
	?>
	<div class="powered"><?tr('powered_by_',array('power'=>$power));?></div>
	
	<script src="nano.js"></script>
	<script>
		function checkform(){
			if (document.skipcheck) return true;
			if (gid('password').value=='') { //&&gid('certid').value==''
				gid('password').focus();
				if (gid('login').value=='') gid('login').focus();
				return false;
			}
			
			return true;
		}
		<?if ($passreset){?>
		gid('password').focus();
		<?}else{?>	
		gid('login').focus();
		<?}?>
	</script>

<script src="smartcard.js"></script>
<script>
smartcard_init('reader',{
	'noplugin':function(){gid('cardlink').style.display='none';},
	'nohttps':function(){gid('cardlink').style.display='none';},
	'inited':function(){gid('cardlink').style.display='block';}	
});

function cardview(){
	gid('passview').style.display='none';
	gid('cardview').style.display='block';
}

function passview(){
	gid('cardview').style.display='none';
	gid('passview').style.display='block';
}

function cardauth(){
/*
	if (gid('login').value=='') {
		gid('login').focus();
		return;
	}
*/
	if (document.reader){
	  document.reader.getcert(function(cert){
	  if (cert){
		gid('certid').value=cert.certificateAsHex;
		gid('cardinfo').innerHTML=cert.CN;
		gid('cardinfo').style.display='block';
		return true;
	  }
	  });
	} else {//no reader
		alert('Smartcard reader not supported');
		return false;
	}
}

</script>

</body>
</html>
