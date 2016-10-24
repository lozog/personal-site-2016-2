<?php

function newproject(){

?>
<div class="section">
    <div class="sectiontitle"><?tr('list_project_add_tab');?></div>
    
<div class="col">
    
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_projecttitle');?>:</div>
        <input class="inp" id="projecttitle_new">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_projectdesc');?>:</div>
        <input class="inp" id="projectdesc_new">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_startdate');?>:</div>
        <input class="inp" id="startdate_new">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_enddate');?>:</div>
        <input class="inp" id="enddate_new">
    </div>
    <div class="inputrow">
        <div class="formlabel"><?tr('project_label_displaydate');?>:</div>
        <input class="inp" id="displaydate_new">
    </div>
        

</div>
<div class="clear"></div>

        <div class="inputrow">
            <button onclick="addproject();"><?tr('button_project_add');?></button>
        </div>

</div>
<?

}
