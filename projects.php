<?
include 'connect.php';

/*
bg:         rgba(34, 34, 34, 1)
beige:      rgba(230,219,116,1)
red:        rgba(249,38,114,1)
blue:       rgba(102,217,239,1)
off-white:  rgba(214,202,188,1)

*/
$colours = array("#222222", "#e6db74", "#f92672", "#66d9ef", "#d6cabc");

$query="select * from projects where ispublic=1 order by startdate desc ";
$rs=sql_query($query,$db);
$i = 0;
while ( $project=sql_fetch_assoc($rs) ){
    $projectid      =$project['projectid']; 
    $projecttitle   =$project['projecttitle'];
    $projectdesc    =$project['projectdesc'];
    
?>
<div class="section project" style="background-color: <? echo $colours[$i];?>">
    <!-- <div id="sitetitle" class="sectionheader">ozog.io</div> -->
    <div class="maincol maincol-content">
        <div class="sectionheader">
        <? echo $projecttitle; ?>
        </div>

        <div id="aboutme" class="sectioncontent">
        <? echo $projectdesc; ?>
        </div>
    </div>
</div>
<?

    $i += 1;
    $i %= count($colours);
} // while

?>


