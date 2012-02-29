<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Event Query</title>
</head>
<body>
<h2>Query Results</h2>

<?php
	class StudentWants {
		public $first_name;
		public $last_name;
		public $school;
		
		public function __construct($first_name, $last_name, $school) {
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->school = $school;
			return true;
		}
		public function __toString() {
			return ("" . $this->first_name . " " . $this->last_name . " FROM " . $this->school); 
		}
	}

$event_one = $_POST["event_one"];

	$DBConnect = mysqli_connect('localhost', 'root', 'deca', 'decaevents') 
	 or die(mysqli_connect_error());
//	 if ($DBConnect===FALSE)
//		echo "<p>Error connecting to MySQL server.</p>\n";

	$query = "SELECT * FROM deca_students WHERE event_one = '".$event_one."'";
	
	$result = mysqli_query($DBConnect, $query)
	 or die("Database query error: " . mysqli_error($DBConnect));
	
	$index = 0;
	
	while($row = mysqli_fetch_array($result))
	{	
		//$student = ( "<p>" . $row['first_name'] .  " " . $row['last_name'] . " - " . "From " . $row['school'] . "</p>");
		$student = new StudentWants(  $row['first_name'], $row['last_name'], $row['school']);
		$students[$index] = $student;
		$index++;
	//	echo $student;
	}

if (@$students & 1) {	
	shuffle($students);
	}
	else {
		echo '<b><center>No Students entered in the Event</center></b><br />';
		}
	
$times = 
    array( 
        array( 
            'start'    => mktime(9, 0, 0), 
            'end'    => mktime(9, 30, 0), 
            'name'    =>@$students[0],
        ), 
        array( 
            'start'    => mktime(9, 30, 0), 
            'end'    => mktime(10, 0, 0), 
            'name'    => @$students[1], 
        ), 
        array( 
            'start'    => mktime(10, 0, 0), 
            'end'    => mktime(10, 30, 0), 
            'name'    => 'Judging' 
        ) 
        , 
        array( 
            'start'    => mktime(10, 30, 0), 
            'end'    => mktime(11, 0, 0), 
            'name'    => @$students[2],
        ), 
        array( 
            'start'    => mktime(11, 0, 0), 
            'end'    => mktime(11, 30, 0), 
            'name'    => @$students[3],
        ) 
        , 
        array( 
            'start'    => mktime(11, 30, 0), 
            'end'    => mktime(12, 0, 0), 
            'name'    => 'Judging' 
        ) 
		,
        array( 
            'start'    => mktime(12, 0, 0), 
            'end'    => mktime(13, 0, 0), 
            'name'    => 'Lunch' 
        ), 
        array( 
            'start'    => mktime(13, 0, 0), 
            'end'    => mktime(13, 30, 0), 
            'name'    => @$students[4],
        ), 
        array( 
            'start'    => mktime(13, 30, 0), 
            'end'    => mktime(14, 0, 0), 
            'name'    => @$students[5],
        ) 
        , 
        array( 
            'start'    => mktime(14, 0, 0), 
            'end'    => mktime(14, 30, 0), 
            'name'    => 'Judging' 
        ), 
        array( 
            'start'    => mktime(14, 30, 0), 
            'end'    => mktime(15, 0, 0), 
            'name'    => @$students[6],
        ) 
        , 
        array( 
            'start'    => mktime(15, 0, 0), 
            'end'    => mktime(15, 30, 0), 
            'name'    => @$students[7],
        ) 
		,
		array( 
            'start'    => mktime(15, 30, 0), 
            'end'    => mktime(16, 0, 0), 
            'name'    => 'Final Judging' 
        ) 
        , 
		array( 
            'start'    => mktime(16, 0, 0), 
            'end'    => mktime(16, 0, 0), 
            'name'    => 'End' 
        ) 
        , 
	); 

$prevTime = mktime(9, 0, 0); 
$prevDay = 1; 
$days = array(); 
$imax = count($times); 
$interval = 30; 
$tdata = array(); 
$colors = array('#FFF', '#FFF', '#CCF', '#FFF', '#FFF', '#CCF', '#CCF', '#FFF', '#FFF', '#CCF', '#FFF', '#FFF', '#CCF', '#CCF', 'none' => '#FFF'); 
$coursesToday = 0; 

$dayIs = date('d'); 
$monthIs = date('m'); 
$yearIs = date('Y'); 
$startHour = 9; 
$endHour = 16; 
$firstTime = mktime($startHour, 0, 0); 
$lastTime = mktime($endHour, 0, 0); 
$daysScheduled = 0; 

$diff = ($lastTime - $firstTime) / (60 * $interval); 
for ($i = 0; $i < $diff; ++$i) { 
    //$tdata[0] = '<td>' . date('G:i', mktime(9, 30 * $i, 0)).'</td>'; 
    $tdata[0][] = '<td>' . date('G:i', mktime(9, 30 * $i, 0)).'</td>'; 
} 
for ($i = 0; $i < $imax; ++$i) { 

    # no students before this interval. pad with empty cells 
    if (($dif = $times[$i]['start'] - $prevTime) > 0) { 
        $rowspan = $dif / (60 * $interval); 
        $tdata[$prevDay][] = '<td rowspan="'.$rowspan.'" style="background-color: '.$colors['none'].';" 
                        >&nbsp;</td>'; 
        for($j = 1; $j < $rowspan; ++$j) 
            $tdata[$prevDay][] = ''; 
        $prevTime = $times[$i]['end']; 
    } 

 
    # There is one more students following this one: overlap possible 
    $overlapPossible = true; 
    while($i + 1 < $imax && $overlapPossible) { 
       # no overlap 
        if ($times[$i]['end'] <= $times[$i + 1]['start']) { 
            $overlapPossible = false; 

            $rowspan = ($times[$i]['end'] - $times[$i]['start']) / (60 * $interval);  
			$rowstring = '<td rowspan="'.$rowspan.'" 
                        style="background-color: '.(isset($times[$i]['color']) ? $times[$i]['color'] : $colors[$coursesToday++]).';'. 
                       (isset($times[$i]['overlap']) ? ' border: 1pt solid red;' : '') .'" 
                            >';
							
			if (is_null($times[$i]['name'])) {
				$rowstring = $rowstring . "&nbsp;";
			}
			elseif (is_string($times[$i]['name'])) {
				$rowstring = $rowstring . $times[$i]['name'];
			}
			else {
					$rowstring = $rowstring . $times[$i]['name']->first_name . " " . $times[$i]['name']->last_name . " " . "<b>From:</b>" . " " . $times[$i]['name']->school;
			}
                            //' ('. date('G:i', $times[$i]['start']) . ' - ' . date('G:i', $times[$i]['end']) . 
                            //')' 
			$tdata[$prevDay][] = $rowstring . '</td>'; 
            for($j = 1; $j < $rowspan; ++$j) 
                $tdata[$prevDay][] = ''; 

        } 
        else { 
            # This time interval for this students completely contains the next students 
            if ($times[$i]['end'] > $times[$i + 1]['end']) { 
                # insert a new array element 
                $times = array_merge(    array_slice($times, 0, $i + 2), 
                                        array( 
                                            array( 
                                                'start'    => $times[$i + 1]['end'], 
                                                'end'    => $times[$i]['end'], 
                                                'name'    => $times[$i]['name'], 
                                                'color'    => $colors[$coursesToday] 
                                            ) 
                                        ), 
                                        array_slice($times, $i + 2) 
                        ); 

                # adjust $imax for new length of array 
                ++$imax; 
                $times[$i + 1]['overlap'] = true; 
                                         
                $times[$i]['origEnd'] = $times[$i]['end']; 
                $times[$i]['end'] = $times[$i + 1]['start']; 

                                 
                $rowspan = ($times[$i]['end'] - $times[$i]['start']) / (60 * $interval); 
                $tdata[$prevDay][] = 
                    '<td rowspan="'.$rowspan.'" 
                    style="background-color: '.(isset($times[$i]['color']) ? $times[$i]['color'] : $colors[$coursesToday++]). 
                                        (isset($times[$i]['overlap']) ? ' border: 1pt solid red;' : '') .'" 
                            >' . $times[$i]['name']->last_name . 
                            //' ('. date('G:i', $times[$i]['start']) . ' - ' . date('G:i', $times[$i]['origEnd']) . 
                            //') '
							'</td>'; 
                for($j = 1; $j < $rowspan; ++$j) 
                    $tdata[$prevDay][] = ''; 
                 
                ++$i; 
                 
            } 
            # Time interval for this student ends in the middle of the next students
            else if ($times[$i]['end'] > $times[$i + 1]['start']) { 
                $times[$i]['origEnd'] = $times[$i]['end']; 
                $times[$i]['end'] = $times[$i + 1]['start']; 

                $times[$i + 1]['overlap'] = true; 
               
                $rowspan = ($times[$i]['end'] - $times[$i]['start']) / (60 * $interval); 
                $tdata[$prevDay][] = 
                    '<td rowspan="'.$rowspan.'" 
                    style="background-color: '.$colors[$coursesToday++].';'. 
                    (isset($times[$i]['overlap']) ? ' border: 1pt solid red;' : '') .'" 
                                >'.$times[$i]['name']->last_name . 
                            //' ('. date('G:i', $times[$i]['start']) . ' - ' . date('G:i', $times[$i]['origEnd']) . 
                            //')' 
							'</td>'; 
                for($j = 1; $j < $rowspan; ++$j) 
                    $tdata[$prevDay][] = ''; 
                $overlapPossible = false; 
            } 
       } 
  } 

    $prevTime = $times[$i]['end']; 
         
} 


		echo "<b><center>EVENT: " . ' ' . $event_one . "</b>" . "</center>" . "<br />";	
	
		echo "<table id='schedlue' border='10' align='center'>";
		echo "";
		echo "<tr style=\"background-color:#CCF\">";
		echo "<td><b>Time</b></td>";
		echo "<td align=center><b>Student & School Name</b></td>";

		echo "</tr>";
		
	$timeMax = count($tdata[0]); 
		for ($timeEntry = 0; $timeEntry < $timeMax; ++$timeEntry) { 
		echo '<tr>'; 
		foreach($tdata as $day) { 
			echo isset($day[$timeEntry]) ? 
				$day[$timeEntry] 
                : 
				'<td style="background-color: '.$colors['none'].';" 
                            >&nbsp;</td>'; 
		} 
		echo '</tr>'; 

	} 
		echo '</tr>';
	'</table>'; 
	
	mysqli_close($DBConnect);

?>



<p><a href="deca.html"><i><b>Go Back to Main Page to Enter Student Information</b></i></a></b></p>
<p><a href="eventQuery.html"><i><b>Query Database by Event</b></i></a></b></p>


</body>
</html>
