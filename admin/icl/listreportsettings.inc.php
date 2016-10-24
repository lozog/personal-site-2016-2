<?php

function listreportsettings(){
	global $db; 
	$mode=GETSTR('mode');
	$key=GETSTR('key');
	
	$page=isset($_GET['page'])?$_GET['page']+0:0;
	
	if ($mode!='embed'){

?>
<div class="section">
<div class="listbar">
	<form class="listsearch" onsubmit="_inline_lookupreportsetting(gid('reportsettingkey'));return false;">
	<div class="listsearch_">
		<input id="reportsettingkey" class="img-mg" onkeyup="_inline_lookupreportsetting(this);">
	</div>
	<input type="image" src="imgs/mg.gif" class="searchsubmit" value=".">
	</form>

	<div style="padding-top:10px;">
	<a class="recadder" onclick="addtab('reportsetting_new','<?tr('list_reportsetting_add_tab');?>','newreportsetting');"> <img src="imgs/t.gif" class="img-addrec" width="18" height="18"><?tr('list_reportsetting_add');?></a>
	</div>
</div>

<div id="reportsettinglist">
<?		
	}

	$query="select * from ".TABLENAME_REPORTS;
	
	$soundex=GETSTR('soundex')+0;
	$sxsearch='';
	if ($soundex&&$key!='') $sxsearch=" or concat(soundex(reportname),'') like concat(soundex('$key'),'%') ";
	
	if ($key!='') $query.=" where (reportname like '%$key%' or reportgroup like '%$key%' $sxsearch) ";
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
<a href=# onclick="ajxpgn('reportsettinglist',document.appsettings.codepage+'?cmd=slv_core__reportsettings&key='+encodeHTML(gid('reportsettingkey').value)+'&page=<?echo $page-1;?>&mode=embed');return false;">&laquo; Prev</a>
|
<a href=# onclick="ajxpgn('reportsettinglist',document.appsettings.codepage+'?cmd=slv_core__reportsettings&key='+encodeHTML(gid('reportsettingkey').value)+'&page=<?echo $page+1;?>&mode=embed');return false;">Next &raquo;</a>
</div>
<?		
	}
	
	$query.=" order by reportgroup, reportname limit $start,$perpage";	
	
	$rs=sql_query($query,$db);

	$lastgroup='';
			
	while ($myrow=sql_fetch_array($rs)){
		$reportid=$myrow['reportid'];
		$reportname=$myrow['reportname'];
		$reportgroup=$myrow['reportgroup'];
		
		$reportsettingtitle="$reportname"; //change this if needed
		
		$dbreportsettingtitle=noapos(htmlspecialchars($reportsettingtitle));
		
		if ($lastgroup!=$reportgroup){
?>
<div class="sectionheader"><?echo $reportgroup;?></div>
<?			
			$lastgroup=$reportgroup;
		}
		
?>
<div class="listitem"><a onclick="showreportsetting(<?echo $reportid;?>,'<?echo $dbreportsettingtitle;?>');"><?echo $reportsettingtitle;?></a></div>
<?		
	}//while
	
	if ($mode!='embed'){
?>
</div>
</div>

<script>
gid('tooltitle').innerHTML='<a><?tr('icon_reportsettings');?></a>';
ajxjs(self.showreportsetting,'reportsettings.js');
</script>
<?	
	}//embed mode

}

