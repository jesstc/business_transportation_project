<?php
// store url and keyword
if(isset($_GET['keyword'])) {
     $keyword = $_GET['keyword'];
     $url = $_GET['url'];
}

// 設定url
    if(isset($keyword)&&isset($url)) {
        $url.=$keyword;
        $pattern = '/<div\sclass\=\"title\">\s*<a\shref\=\"(\S*)\">(.*?)<\/a>\s*<\/div>/';
     } else echo "NO !!!!!!!!!!!";
    // echo $url."<br>";

$ch = curl_init();

curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIE, 'over18=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$data = curl_exec($ch);
curl_close($ch);

// 找出 title & href
preg_match_all($pattern,$data,$titles, PREG_PATTERN_ORDER); 

for($i=0; $i<=9; $i++) {
    $href = $titles[1][$i];
    $titles[1][$i] = "https://www.ptt.cc".$href;
}

// echo top1~top10
echo "<div style='color:#727a82; font-family:微軟正黑體;'>";
for ($j=0; $j<=9; $j++) {
    $rank = $j+1;
    echo $rank.". "."<a href='".$titles[1][$j]."' target='_blank' style='color:#727a82; font-family:微軟正黑體;'>".$titles[2][$j]."</a><br>";
}
echo "</div>";

?>

<!DOCTYPE html>   
<html>   
    <head>
    </head>
    <body>
   
    </body>
</html>