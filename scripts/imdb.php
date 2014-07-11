<?php
#$json=file_get_contents("http://www.omdbapi.com/?t=titanic&y=1997");
#$json=file_get_contents("http://www.omdbapi.com/?i=tt0067482");
$json=file_get_contents("http://www.omdbapi.com/?i=tt1951264");
#$json=file_get_contents("xml.json");
echo $json, "\n";
$info=json_decode($json);
print_r($info);
echo $info->imdbRating, "\n";
?>
