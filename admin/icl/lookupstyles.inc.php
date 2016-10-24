<?php

function lookupstyles(){
	$mode=GETSTR('mode');
	$id=GETVAL('id');
	
	global $db;
	
?>
<div class="section">
<?	
	switch ($mode){
		case 'systemplate':
			$query="select * from templates where templateid=$id";
			$rs=sql_query($query,$db);
			$myrow=sql_fetch_assoc($rs);
			$templatetypeid=$myrow['templatetypeid']+0;
			$query="select * from templatetypes where templatetypeid=$templatetypeid";
			$rs=sql_query($query,$db);
			$myrow=sql_fetch_assoc($rs);
			$classes=explode(',',$myrow['classes']);
			foreach ($classes as $class){
			?>
			<div class="listitem" style="cursor:pointer;" onclick="if (document.hotspot&&document.hotspot.selection) {document.hotspot.selection.setContent('<div class=&quot;<?echo $class;?>&quot;><p>'+(document.hotspot.selection.getContent()==''?'Text':document.hotspot.selection.getContent())+'</p></div>');document.hotspot.focus();}">
				<a>.<?echo $class;?></a>
				<div class="pickerstyle_<?echo $class;?>"><span>ABC</span></div>
			</div>
			<?	
			}	
			
		break;
		default: echo 'undefined style handler '.$mode;
	}	
?>
	<div style="padding:20px 0;font-size:12px;color:#444444;line-height:1.5em;"><em>
		Developer notes: Styles are defined in
		<ul>
		<li>toolbar.css</li>
		<li>tine_mce/editor.css</li>
		<li>../style.css</li>
		</ul>
	</em>
	</div>	
</div>
<?
}