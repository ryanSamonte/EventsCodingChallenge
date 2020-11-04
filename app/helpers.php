<?php
    if (!function_exists('getInclusiveDates')) {
        function getInclusiveDates($start_date, $end_date, $format = 'Y-m-d') {
            $dates = array(); 
            
            $interval = new DateInterval('P1D'); 
        
            $end_date_convert = new DateTime($end_date); 
            $end_date_convert->add($interval); 
        
            $period = new DatePeriod(new DateTime($start_date), $interval, $end_date_convert); 
        
            foreach($period as $date) {                  
                $dates[] = $date->format($format);
            } 
        
            return $dates; 
        }
    }

    if(!function_exists('extractDate')) {
        function extractDate($date, $date_part) {
            $timestamp = strtotime($date);

            $extracted_date = date($date_part, $timestamp);
            
            return $extracted_date;
        }
    }
?>