<?php

include 'icl/showproject.inc.php';

function updateproject(){
    $projectid=GETVAL('projectid'); 
    $projecttitle=QETSTR('projecttitle');
    $projectdesc=QETSTR('projectdesc');
    $startdate=QETSTR('startdate');
    $enddate=QETSTR('enddate');
    $displaydate=QETSTR('displaydate');


    global $db;

    $query="update projects set projecttitle='$projecttitle',projectdesc='$projectdesc',startdate='$startdate',enddate='$enddate',displaydate='$displaydate' where projectid=$projectid";
    sql_query($query,$db);

    logaction("updated Project #$projectid <u>$projecttitle</u>",
        array('projectid'=>$projectid,'projecttitle'=>"$projecttitle"),
        array('rectype'=>'project','recid'=>$projectid));

    showproject($projectid);
}
