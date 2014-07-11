<?php
$album  = $_GET['album'];
$type   = $_GET['type'];

$url = "http://192.168.1.12/~as64720/";
$html_root="/home/as64720/public_html";
header("Content-Type: text/plain");

$dir = $html_root."/".$album;

echo "#EXTM3U\n";
echo "#EXT-X-VERSION:3\n";
if( file_exists("$dir"."/"."video.720.m3u8") )
{
      echo "#EXT-X-STREAM-INF:PROGRAM-ID=1, BANDWIDTH=2000000\n";
      echo $url.$album."/video.720.m3u8\n";
}
if( file_exists("$dir"."/"."video.720.medium.m3u8") )
{
      echo "#EXT-X-STREAM-INF:PROGRAM-ID=1, BANDWIDTH=1000000\n";
      echo $url.$album."/video.720.medium.m3u8\n";
}
if( file_exists("$dir"."/"."video.720.low.m3u8") )
{
      echo "#EXT-X-STREAM-INF:PROGRAM-ID=1, BANDWIDTH=600000\n";
      echo $url.$album."/video.720.low.m3u8\n";
}
?>
