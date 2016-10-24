showproject=function(projectid,name){
    addtab('project_'+projectid,name,'showproject&projectid='+projectid);   
}

_inline_lookupproject=function(d){
    var soundex='';
    if (d.soundex) soundex='&soundex=1';
    
    if (d.timer) clearTimeout(d.timer);
    d.timer=setTimeout(function(){
        ajxpgn('projectlist',document.appsettings.codepage+'?cmd=slv_codegen__projects&mode=embed&key='+encodeHTML(d.value)+soundex);
    },300
    );  
}


addproject=function(){

    var suffix='new';
    var oprojecttitle=gid('projecttitle_'+suffix);
    var oprojectdesc=gid('projectdesc_'+suffix);
    var ostartdate=gid('startdate_'+suffix);
    var oenddate=gid('enddate_'+suffix);
    var odisplaydate=gid('displaydate_'+suffix);

    
    var valid=1;
    var offender=null;
    
    //delete the excessive validate rules
    if (!valstr(oprojecttitle)) {valid=0; offender=offender||oprojecttitle;}
    if (!valstr(oprojectdesc)) {valid=0; offender=offender||oprojectdesc;}
    if (!valstr(ostartdate)) {valid=0; offender=offender||ostartdate;}
    if (!valstr(oenddate)) {valid=0; offender=offender||oenddate;}
    if (!valstr(odisplaydate)) {valid=0; offender=offender||odisplaydate;}

    //add more validation rules
    
    if (!valid) {
        if (offender&&offender.focus) offender.focus();
        return;
    }

    var projecttitle=encodeHTML(oprojecttitle.value);
    var projectdesc=encodeHTML(oprojectdesc.value);
    var startdate=encodeHTML(ostartdate.value);
    var enddate=encodeHTML(oenddate.value);
    var displaydate=encodeHTML(odisplaydate.value);
    
    var params=[];
    params.push('projecttitle='+projecttitle);
    params.push('projectdesc='+projectdesc);
    params.push('startdate='+startdate);
    params.push('enddate='+enddate);
    params.push('displaydate='+displaydate);

    
    reloadtab('project_new',oprojecttitle.value,'addproject',function(req){
        var projectid=req.getResponseHeader('newrecid');        
        reloadview('codegen.projects','projectlist');
    },params.join('&'));
    
}

updateproject=function(projectid){
    var suffix=projectid;
    var oprojecttitle=gid('projecttitle_'+suffix);
    var oprojectdesc=gid('projectdesc_'+suffix);
    var ostartdate=gid('startdate_'+suffix);
    var oenddate=gid('enddate_'+suffix);
    var odisplaydate=gid('displaydate_'+suffix);

    
    var valid=1;
    var offender=null;
    
    //delete the excessive validate rules
    if (!valstr(oprojecttitle)) {valid=0; offender=offender||oprojecttitle;}
    if (!valstr(oprojectdesc)) {valid=0; offender=offender||oprojectdesc;}
    if (!valstr(ostartdate)) {valid=0; offender=offender||ostartdate;}
    if (!valstr(oenddate)) {valid=0; offender=offender||oenddate;}
    if (!valstr(odisplaydate)) {valid=0; offender=offender||odisplaydate;}

    //add more validation rules
    
    if (!valid) {
        if (offender&&offender.focus) offender.focus();
        return;
    }
    
    var projecttitle=encodeHTML(oprojecttitle.value);
    var projectdesc=encodeHTML(oprojectdesc.value);
    var startdate=encodeHTML(ostartdate.value);
    var enddate=encodeHTML(oenddate.value);
    var displaydate=encodeHTML(odisplaydate.value);
    
    var params=[];
    params.push('projecttitle='+projecttitle);
    params.push('projectdesc='+projectdesc);
    params.push('startdate='+startdate);
    params.push('enddate='+enddate);
    params.push('displaydate='+displaydate);

    
    reloadtab('project_'+projectid,oprojecttitle.value,'updateproject&projectid='+projectid,function(){
        reloadview('codegen.projects','projectlist');
        flashstatus(document.dict['statusflash_updated']+oprojecttitle.value,5000);
    },params.join('&'));
    
}


delproject=function(projectid){
    if (!confirm(document.dict['confirm_project_delete'])) return;
    
    reloadtab('project_'+projectid,null,'delproject&projectid='+projectid,function(){
        closetab('project_'+projectid);
        reloadview('codegen.projects','projectlist');
    });
}
