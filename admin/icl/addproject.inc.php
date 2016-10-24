<?php

include 'icl/showproject.inc.php';

function addproject(){
    
    $projecttitle=QETSTR('projecttitle');
    $projectdesc=QETSTR('projectdesc');
    $startdate=QETSTR('startdate');
    $enddate=QETSTR('enddate');
    $displaydate=QETSTR('displaydate');
    
    global $db;
    
    $query="insert into projects (projecttitle,projectdesc,startdate,enddate,displaydate) values ('$projecttitle','$projectdesc','$startdate','$enddate','$displaydate') ";
    $rs=sql_query($query,$db);
    $projectid=sql_insert_id($db,$rs)+0;

    if (!$projectid) {
        header('apperror:'._tr('error_creating_record'));die();
    }
    
    logaction("added Project #$projectid <u>$projecttitle</u>",array('projectid'=>$projectid,'projecttitle'=>"$projecttitle"));
    
    header('newrecid:'.$projectid);
    header('newkey:project_'.$projectid);
    header('newparams:showproject&projectid='.$projectid);
    
    showproject($projectid);
}

