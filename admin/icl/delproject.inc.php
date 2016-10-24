<?php

function delproject(){
    $projectid=GETVAL('projectid');
    global $db;
    
    $query="select * from projects where projectid=$projectid";
    $rs=sql_query($query,$db);
    if (!$myrow=sql_fetch_array($rs)) die('Invalid project record');
    
    $projecttitle=$myrow['projecttitle'];
    
    $query="delete from projects where projectid=$projectid";
    sql_query($query,$db);
    
    logaction("deleted Project #$projectid <u>$projecttitle</u>",
        array('projectid'=>$projectid,'projecttitle'=>$projecttitle),
        array('rectype'=>'project','recid'=>$projectid));
}
