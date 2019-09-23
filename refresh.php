<?php
include "session.inc";
include "dbh.inc";
$data = array(
    'timeAproximate' => '',
    'time' => ''
);
if(isset($_SESSION['username']) && isset($_SESSION['administrator']) && $_SESSION['administrator'] == false && isset($_SESSION['userID']) && isset($_SESSION['ticketId']) &&  $_SESSION['ticketId'] > -1 ) {
    $time = new DateTime();
    $ticket = $_SESSION['ticketId'];
    $countCheck = "SELECT COUNT(serviced_check) FROM SERVING
WHERE serviced_check = 0 AND _id < '$ticket'
GROUP BY serviced_check";
    if($res = mysqli_query($sql, $countCheck))
    {
        if($res->num_rows > 0)
        {
            while ($row = mysqli_fetch_row($res))
            {
                $time = $row[0] * AverageTime($sql);
                $data['timeAproximate'] = "Vidutinis laukimo laikas pagal specialista: ". date("H:i:s",$time) . " (Valandos:Minutes:Sekundes)";
            }
        }
        else{
            $data['timeAproximate'] = "";
        }
    }
    $dataReturned = checkTime($sql, $_SESSION['userID']);
    if($dataReturned['res'] == true) {
        $data['time'] = "laukimo laikas: " . $dataReturned['data'] . "(min)";
    }
    else {
        $data['time'] = "laukimo laikas: " . $dataReturned['data'];
    }
    echo json_encode($data);
}
else{
    header("Location: ./index.php");
}