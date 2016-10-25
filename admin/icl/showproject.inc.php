<?php

function showproject($projectid=null){
    if (!isset($projectid)) $projectid=GETVAL('projectid');
    
    global $db;
    
    $query="select * from projects where projectid=$projectid";
    $rs=sql_query($query,$db);
    
    if (!$myrow=sql_fetch_array($rs)) die(_tr('record_removed'));
    
    $projecttitle=$myrow['projecttitle'];
    $projectdesc=$myrow['projectdesc'];
    $startdate=$myrow['startdate'];
    $enddate=$myrow['enddate'];
    $displaydate=$myrow['displaydate'];
    $ispublic=$myrow['ispublic']+0;
    $isfeatured=$myrow['isfeatured']+0;

    header('newtitle:'.base64_encode($projecttitle));
?>
<div class="section">
    <div class="sectiontitle"><?echo $projecttitle;?></div>

    <div class="col">


    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_projecttitle');?>:</div>
        <input class="inpmed" id="projecttitle_<?echo $projectid;?>" value="<?echo htmlspecialchars($projecttitle);?>">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_projectdesc');?>:</div>
        <!-- <input class="inpmed" id="projectdesc_<?echo $projectid;?>" value="<?echo htmlspecialchars($projectdesc);?>"> -->
        <textarea class="inplong" style="height:300px" id="projectdesc_<?echo $projectid;?>"><?echo htmlspecialchars($projectdesc);?></textarea>
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_startdate');?>:</div>
        <input class="inpmed" id="startdate_<?echo $projectid;?>" value="<?echo htmlspecialchars($startdate);?>">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_enddate');?>:</div>
        <input class="inpmed" id="enddate_<?echo $projectid;?>" value="<?echo htmlspecialchars($enddate);?>">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_displaydate');?>:</div>
        <input class="inpmed" id="displaydate_<?echo $projectid;?>" value="<?echo htmlspecialchars($displaydate);?>">
    </div>
    <div class="inputrow">
        <div class="formlabel oneline"><?tr('project_label_ispublic');?></div>
        <input type="checkbox" id="ispublic_<?echo $projectid;?>" <?if($ispublic) echo 'checked';?> >
    </div>
    <div class="inputrow">
        <div class="formlabel oneline"><?tr('project_label_isfeatured');?></div>
        <input type="checkbox" id="isfeatured_<?echo $projectid;?>" <?if($isfeatured) echo 'checked';?> >
    </div>

    
    <div class="inputrow">
        <button onclick="updateproject(<?echo $projectid;?>);"><?tr('button_update');?></button>

        &nbsp; &nbsp;
        <button class="warn" onclick="delproject(<?echo $projectid;?>);"><?tr('button_delete');?></button>


    </div>


    </div>
    <div class="col">

    </div>
    <div class="clear"></div>
</div>
<?
}
