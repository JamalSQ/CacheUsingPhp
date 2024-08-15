<?php

$conn=new PDO("mysql:host=localhost;dbname=phpcache;","root","");

$start_time=microtime(true);
$cacheFile="test/data.cache.php";
if(file_exists($cacheFile) && filemtime($cacheFile) > time()-20){

    echo "from cache file";
    include $cacheFile;
}else{

$sql="SELECT student.name,city.city,game.game,teacher.teacher,study.study FROM student,city,game,teacher,fee,study WHERE student.city=city.id AND student.game=game.id AND student.teacher=teacher.id AND student.study=study.id AND student.id=fee.student_id";

$statment=$conn->prepare($sql);
$statment->execute();
$arr=$statment->fetchAll(PDO::FETCH_ASSOC);

    $str="<table border='1'>";
        $str.="<tr><td>Name</td><td>city</td><td>game</td><td>study</td><td>teacher</td></tr>";
        foreach($arr as $list){
            $str.="<tr><td>".$list['name']."</td><td>".$list['city']."</td><td>".$list['game']."</td><td>".$list['study']."</td><td>".$list['teacher']."</td></tr>";
        }
    $str.="</table>";
    $handler=fopen($cacheFile,'w');
    fwrite($handler,$str);
    fclose($handler);
    echo "Cache created";
    echo $str;
}
$end_time=microtime(true);
echo round($end_time-$start_time,4);

