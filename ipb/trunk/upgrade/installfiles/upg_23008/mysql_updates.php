<?php

$SQL[] = "ALTER TABLE ibf_profile_portal ADD pp_about_me MEDIUMTEXT NULL;";

$SQL[] = "ALTER TABLE ibf_moderator_logs CHANGE topic_title topic_title VARCHAR( 255 ) NULL DEFAULT NULL ,
			CHANGE query_string query_string VARCHAR( 255 ) NULL DEFAULT NULL ;";

$SQL[] = "UPDATE ibf_cal_events SET event_unix_from= (event_unix_from - (event_tz * 2)), event_unix_from= (event_unix_from - (event_tz * 2)) WHERE event_timeset != 0;";


?>