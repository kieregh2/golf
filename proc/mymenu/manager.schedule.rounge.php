<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';
$areaList = getArea();
$sql      = "select *
				from s_ground_data
			where manager_uid='".$my['uid']."'";

//echo $sql;
$RCD      = mysql_query($sql) or die(mysql_error());

?>
            <div class="schedule-list dim-gray-bg">

			<?php while($R=mysql_fetch_assoc($RCD)):?> 
			<?php 
		
			if($my['uid']) {
				$friend = mysql_fetch_assoc(mysql_query("select name from rb_s_mbrdata where memberuid='".$R['friend_uid']."'")); 
				$goHref = "getMymenuList('manager.schedule.time')";
			} else {
				$farow = array();
				$goHref = "getLogin()";
			}

			$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
			?>


                <div class="schedule-item">
                    <span id="ground_uid" class="favorite-place" onclick="<?=$goHref?>">[<?=$areaList[$R['area1']]['name']?>]</span><span class="favorite-resortname"><?=$R['name']?></span>
                </div>
			<?php endwhile?>
            </div>


	
		






