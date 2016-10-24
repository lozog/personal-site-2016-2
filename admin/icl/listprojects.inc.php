<?php

function listprojects(){
    global $db; 
    $mode=GETSTR('mode');
    $key=GETSTR('key');
    
    $page=isset($_GET['page'])?$_GET['page']+0:0;
    
    if ($mode!='embed'){

?>
<div class="section">
<div class="listbar">
    <form class="listsearch" onsubmit="_inline_lookupproject(gid('projectkey'));return false;">
    <div class="listsearch_">
        <input id="projectkey" class="img-mg" onkeyup="_inline_lookupproject(this);">
    </div>
    <input type="image" src="imgs/mg.gif" class="searchsubmit" value=".">
    </form>

    <div style="padding-top:10px;">
    <a class="recadder" onclick="addtab('project_new','<?tr('list_project_add_tab');?>','newproject');"> <img src="imgs/t.gif" class="img-addrec" width="18" height="18"><?tr('list_project_add');?></a>
    </div>
</div>

<div id="projectlist">
<?      
    }

    $query="select * from projects ";
    
    $soundex=GETSTR('soundex')+0;
    $sxsearch='';
    if ($soundex&&$key!='') $sxsearch=" or concat(soundex(projecttitle),'') like concat(soundex('$key'),'%') ";
    
    if ($key!='') $query.=" where (projecttitle like '$key%' or projectdesc like '$key%' $sxsearch) ";
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
<a href=# onclick="ajxpgn('projectlist',document.appsettings.codepage+'?cmd=slv_codegen__projects&key='+encodeHTML(gid('projectkey').value)+'&page=<?echo $page-1;?>&mode=embed');return false;">&laquo; Prev</a>
|
<a href=# onclick="ajxpgn('projectlist',document.appsettings.codepage+'?cmd=slv_codegen__projects&key='+encodeHTML(gid('projectkey').value)+'&page=<?echo $page+1;?>&mode=embed');return false;">Next &raquo;</a>
</div>
<?      
    }
    
    $query.=" order by projecttitle, startdate limit $start,$perpage";  
    
    $rs=sql_query($query,$db);
    
    while ($myrow=sql_fetch_array($rs)){
        $projectid=$myrow['projectid'];
        $projecttitle=$myrow['projecttitle'];
        
        $projecttitle="$projecttitle"; //change this if needed
        
        $dbprojecttitle=noapos(htmlspecialchars($projecttitle));
?>
<div class="listitem"><a onclick="showproject(<?echo $projectid;?>,'<?echo $dbprojecttitle;?>');"><?echo $projecttitle;?></a></div>
<?      
    }//while
    
    if ($mode!='embed'){
?>
</div>
</div>

<script>
gid('tooltitle').innerHTML='<a><?tr('icon_projects');?></a>';
ajxjs(self.showproject,'projects.js');
</script>
<?  
    }//embed mode

}

