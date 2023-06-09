<?php

$logFilePath = 'C:/xampp/apache/logs/access.log'; // Günlük dosyasının yolu

if (file_exists($logFilePath)) {
    $logFile = fopen($logFilePath, 'r');
    if ($logFile) {
        $firstLogTime = 0;
        $lastLogTime = 0;
        
        while (($line = fgets($logFile)) !== false) {
            if (preg_match('/\[(\d{2})\/(\w{3})\/(\d{4}):(\d{2}):(\d{2}):(\d{2})/', $line, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];
                $hour = $matches[4];
                $minute = $matches[5];
                $second = $matches[6];
                
                $logDateTime = strtotime("$day $month $year $hour:$minute:$second");
                
                if ($firstLogTime === 0) {
                    $firstLogTime = $logDateTime;
                }
                
                $lastLogTime = $logDateTime;
            }
        }
        
        fclose($logFile);
        
        if ($firstLogTime > 0 && $lastLogTime > 0) {
            $timeDiff = $lastLogTime - $firstLogTime;
            $days = floor($timeDiff / (24 * 60 * 60));
            $hours = floor(($timeDiff % (24 * 60 * 60)) / (60 * 60));
            $minutes = floor(($timeDiff % (60 * 60)) / 60);
            $seconds = $timeDiff % 60;
            
            echo 'Sitenin açık olduğu süre: ' . $days . ' gün, ' . $hours . ' saat, ' . $minutes . ' dakika, ' . $seconds . ' saniye';
        } else {
            echo 'Günlük dosyasında yeterli veri bulunamadı.';
        }
    } else {
        echo 'Günlük dosyası okunamıyor.';
    }
} else {
    echo 'Günlük dosyası bulunamadı.';
}

?>
