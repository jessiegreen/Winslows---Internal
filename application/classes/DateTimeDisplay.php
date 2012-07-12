<?php
/**
 * Description of DateTime
 *
 * @author jgreen
 */
namespace Classes;

class DateTimeDisplay {
    public static function formatDateTimeSqlTo($sql_date_time){
	$time	    = strtotime($sql_date_time);
	$DateTime   = DateTime::createFromFormat("Y-m-d H:i:s", $time);
	
	return $DateTime->format("F j, Y, g:i a");
    }
}

?>
