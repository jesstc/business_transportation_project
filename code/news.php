<?php
    // store url and keyword
    if(isset($_GET['keyword']) && isset($_GET['media'])) {
        $keyword = $_GET['keyword'];
        $media = $_GET['media'];
    }

    // 判斷media並設定對應的url
    if(isset($media) && isset($keyword)) {
        switch ($media) {
            case '中央社':
                $url = "https://www.cna.com.tw/search/hysearchws.aspx?q=".$keyword;
                $pattern = '/<li><a\shref\=\"(\S*)\">.*?<div\sclass\=\"listInfo\"><h2>(.*?)<\/h2>/';
                break;
            
            case '聯合新聞網':
                $url = "https://udn.com/search/result/2/".$keyword;
                $pattern = '/<dt>\s*<a\shref\=\"(\S*)\"\starget\=\"_blank\">\s*.*\s*<h2>(.*)<\/h2>/';
                break;
                
            case 'TVBS':
                $url = "https://news.tvbs.com.tw/news/searchresult/news?search_text=".$keyword;
                $pattern = '/<li><a\shref\=\"(\S*)\"\sclass\=\"search_list_box\">.*?<div\sclass\=\"search_list_txt\">(.*?)<\/div>/';
                break;
            
            case '風傳媒':
                $url = "https://www.storm.mg/site-search/result?q=".$keyword;
                $pattern = '/<a\sclass\=\"card_link link_title\"\shref\=\"(\S*)\">\s*<p\sclass\=\"card_title\">(.*?)<\/p>\s*<\/a>/';
                break;
                
            case '蘋果日報':
                $url = "https://tw.appledaily.com/search/result?querystrS=".$keyword;
                $pattern = '/<h2><a\shref\=\"(\S*)\"\starget\=\"_blank\">\s*(.*?)\s*</';
                break;
            
            case 'ETtoday':
                $url = "https://www.ettoday.net/news_search/doSearch.php?keywords=".$keyword;
                $pattern = '/<h2><a\shref\=\"(\S*)\"\s.*?>(.*?)<\/a><\/h2>/';
                break;
            
            case '自由電子報':
                $url = "https://news.ltn.com.tw/search?keyword=".$keyword;
                $pattern = '/<a\sclass\=\"tit\"\shref\=\"(\S*)\".*?>(.*?<\/a>)/';
                break;
                
            case '三立新聞網':
                $url = "https://www.setn.com/search.aspx?r=0&q=".$keyword;
                $pattern = '/<div\sclass\=\"newsimg-area-item-2\s\">\s*<a.*?href\=\"(.*)\"\s.*\s*.*\s*.*\s*.*\s*.*\s*.*?>(.*)<\/div>/';
                break;
            
            default:
                echo "media not found!!!!!!!";
                break;
        }
    } else echo "NO MEDIAAAAAAAAAAAAA!!!!!!!!!!!";
    
    // CURL 
    $ch = curl_init();

    // curl相關設定
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        ]);
    $data = curl_exec($ch); 

    // 關閉連接
    curl_close($ch);  
    
    // 找出 title & href
    preg_match_all($pattern,$data,$titles, PREG_PATTERN_ORDER); 

    // 風傳媒&三立新聞網抓到的網址前面要加上原網址
    if($media == '風傳媒'){
        for($i=0; $i<=9; $i++) {
            $href = $titles[1][$i];
            $titles[1][$i] = "https://www.storm.mg".$href;
        }
    }else if($media == '三立新聞網') {
        for($i=0; $i<=9; $i++) {
            $href = $titles[1][$i];
            $titles[1][$i] = "https://www.setn.com/".$href;
        }
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