<?php

function listtemplatetypes(){
	global $db; 
	$mode=GETSTR('mode');
	$key=GETSTR('key');
	
	$page=isset($_GET['page'])?$_GET['page']+0:0;
	
	$user=userinfo();
	
	if ($mode!='embed'){

?>
<div class="section">
<div class="listbar">
	<form class="listsearch" onsubmit="_inline_lookuptemplatetype(gid('templatetypekey'));return false;">
	<div class="listsearch_">
		<input id="templatetypekey" class="img-mg" onkeyup="_inline_lookuptemplatetype(this);">
	</div>
	<input type="image" src="imgs/mg.gif" class="searchsubmit" value=".">
	</form>

	<?
	if ($user['groups']['systemplate']){
	?>
	<div style="padding-top:10px;">
	<a class="recadder" onclick="addtab('templatetype_new','<?tr('list_templatetype_add_tab');?>','newtemplatetype');"> <img src="imgs/t.gif" class="img-addrec" width="18" height="18"><?tr('list_templatetype_add');?></a>
	</div>
	<?
	}
	?>
</div>

<div id="templatetypelist">
<?		
	}

	$query="select * from templatetypes ";
	
	$soundex=GETSTR('soundex')+0;
	$sxsearch='';
	if ($soundex&&$key!='') $sxsearch=" or concat(soundex(templatetypename),'') like concat(soundex('$key'),'%') ";
	
	if ($key!='') $query.=" where (templatetypename like '%$key%' or templatetypekey like '$key%' $sxsearch) ";
	$rs=sql_query($query,$db);
	$count=sql_affected_rows($db,$rs);
	
	$perpage=20;
	$maxpage=ceil($count/$perpage)-1;
	if ($maxpage<0) $maxpage=0;
	if ($page<0) $page=0;
	if ($page>$maxpage) $page=$maxpage;
	$start=$perpage*$page;

	if ($maxpage>0){
?>
<div style="font-size:12px;padding:10px 0;">
<?echo $page+1;?> of <?echo $maxpage+1;?>
&nbsp;
<a href=# onclick="ajxpgn('templatetypelist',document.appsettings.codepage+'?cmd=slv_core__templatetypes&key='+encodeHTML(gid('templatetypekey').value)+'&page=<?echo $page-1;?>&mode=embed');return false;">&laquo; Prev</a>
|
<a href=# onclick="ajxpgn('templatetypelist',document.appsettings.codepage+'?cmd=slv_core__templatetypes&key='+encodeHTML(gid('templatetypekey').value)+'&page=<?echo $page+1;?>&mode=embed');return false;">Next &raquo;</a>
</div>
<?		
	}
	
	$query.=" order by templatetypename limit $start,$perpage";	
	
	$rs=sql_query($query,$db);
	
	while ($myrow=sql_fetch_array($rs)){
		$templatetypeid=$myrow['templatetypeid'];
		$templatetypename=$myrow['templatetypename'];
		
		$templatetypetitle="$templatetypename"; //change this if needed
		
		$dbtemplatetypetitle=noapos(htmlspecialchars($templatetypetitle));
?>
<div class="listitem"><a onclick="showtemplatetype(<?echo $templatetypeid;?>,'<?echo $dbtemplatetypetitle;?>');"><?echo $templatetypetitle;?></a></div>
<?		
	}//while
	
	if ($mode!='embed'){
?>
</div>
</div>

<script>
gid('tooltitle').innerHTML='<a><?tr('icon_templatetypes');?></a>';
ajxjs(self.showtemplatetype,'templatetypes.js');
</script>
<?	
	}//embed mode

}

