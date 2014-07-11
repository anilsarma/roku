<?php
header("Content-Type: text/plain\n");
?>
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<feed>
<itemSeries title="Movies Grid" description="Public Movies" sd_img="" hdImg="http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/title_320x180.jpeg">
	<item adImg="http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/title_320x180.jpeg"  hdImg="http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/title_320x180.jpeg" >
          <title>X-Men: Days of Future Past</title>
          <description>The X-Men send Wolverine to the past in a desperate effort to change history and prevent an event that results in doom for both humans and mutants.</description>
           <contentId>8039</contentId>
           <contentType>movie</contentType>
           <contentQuality>HD</contentQuality>
           <streamFormat>mp4</streamFormat>
           <SDBifUrl>http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/trick-SD.bif</SDBifUrl>
           <HDBifUrl>http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/trick-SD.bif</HDBifUrl>
           <media>
              <streamFormat>mp4</streamFormat>
              <streamQuality>HD</streamQuality>
              <streamBitrate>0</streamBitrate>
              <streamUrl>http://192.168.1.12/~as64720/movies/X-Men.Days.of.Future.Past/movie.mp4</streamUrl>
           </media>
          <synopsis>English, Vietnamese, French
The X-Men send Wolverine to the past in a desperate effort to change history and prevent an event that results in doom for both humans and mutants.</synopsis>
          <genre>Action, Adventure, Sci-Fi</genre>
          <starRating>80</starRating>
          <rating>PG-13</rating>
          <actors>Hugh Jackman, James McAvoy, Michael Fassbender, Jennifer Lawrence</actors>
          <runtime>7586</runtime>
      </item>
<item adImg="http://192.168.1.12/~as64720/movies/A.Million.Ways.To.Die.In.The.West/title_320x180.jpeg"  hdImg="http://192.168.1.12/~as64720/movies/A.Million.Ways.To.Die.In.The.West/title_320x180.jpeg" >
          <title>A Million Ways to Die in the West</title>
          <description>As a cowardly farmer begins to fall for the mysterious new woman in town, he must put his new-found courage to the test when her husband, a notorious gun-slinger, announces his arrival.</description>
           <contentId>8002</contentId>
           <contentType>movie</contentType>
           <contentQuality>HD</contentQuality>
           <streamFormat>hls</streamFormat>
           <SDBifUrl>http://192.168.1.12/~as64720/movies/A.Million.Ways.To.Die.In.The.West/trick-SD.bif</SDBifUrl>
           <HDBifUrl>http://192.168.1.12/~as64720/movies/A.Million.Ways.To.Die.In.The.West/trick-SD.bif</HDBifUrl>
           <media>
              <streamFormat>hls</streamFormat>
              <streamQuality>HD</streamQuality>
              <streamBitrate>0</streamBitrate>
              <streamUrl>http://192.168.1.12/~as64720/movies/A.Million.Ways.To.Die.In.The.West/video.720.m3u8</streamUrl>
           </media>
          <synopsis>English
As a cowardly farmer begins to fall for the mysterious new woman in town, he must put his new-found courage to the test when her husband, a notorious gun-slinger, announces his arrival.</synopsis>
          <genre>Comedy, Western</genre>
          <starRating>60</starRating>
          <rating>R</rating>
          <actors>Seth MacFarlane, Charlize Theron, Amanda Seyfried, Liam Neeson</actors>
          <runtime>6670</runtime>
</item>
 </itemSeries>

<?php
function generate_item( $id, $file, $m3u8_file, $title, $streamFormat, $imdb, $time )
{
			      echo "		";
			      echo "<item adImg=\"http://192.168.1.12/~as64720/movies/$file/$title\" ";
			      echo " hdImg=\"http://192.168.1.12/~as64720/movies/$file/$title\" >\n";
                              if(isset($imdb))
			      {
                                      echo "          <title>", $imdb->Title, "</title>\n";
                                      echo "          <description>", $imdb->Plot, "</description>\n";
                              }
			      else
			      {
                                  echo "           <title>$file</title>\n"; 
			      }
                              echo "           <contentId>$id</contentId>\n"; 
                              echo "           <contentType>movie</contentType>\n"; 
                              echo "           <contentQuality>HD</contentQuality>\n";
                              echo "           <streamFormat>$streamFormat</streamFormat>\n";
                              echo "           <SDBifUrl>http://192.168.1.12/~as64720/movies/$file/trick-SD.bif</SDBifUrl>\n";
                              echo "           <HDBifUrl>http://192.168.1.12/~as64720/movies/$file/trick-SD.bif</HDBifUrl>\n";
                              echo "           <media>\n";
                              echo "              <streamFormat>$streamFormat</streamFormat>\n";
                              echo "              <streamQuality>HD</streamQuality>\n";
                              echo "              <streamBitrate>0</streamBitrate>\n";
                              echo "              <streamUrl>http://192.168.1.12/~as64720/movies/$file/$m3u8_file</streamUrl>\n";
                              echo "           </media>\n";
                              if(isset($imdb))
			      {
                                      echo "          <synopsis>", $imdb->Language, "\n", $imdb->Plot, "</synopsis>\n";
                                      echo "          <genre>", $imdb->Genre, "</genre>\n";
                                      $rating = (int)$imdb->imdbRating * 10;
                                      echo "          <starRating>", $rating, "</starRating>\n";
                                      echo "          <rating>", $imdb->Rated, "</rating>\n";
                                      echo "          <actors>", $imdb->Actors, "</actors>\n";
                              }
			      else
			      {
                                      echo "          <synopsis>English</synopsis>\n";
                                      echo "          <genre>Clip</genre>\n";
                              }
                           
                              echo "          <runtime>$time</runtime>\n";
			      echo "</item>\n";
}
?>
          <?php
               $dir_root = "/home/as64720/public_html";
               $url_root = "http://192.168.1.12/~as64720";
               $subdir = "movies";
               $dir = $dir_root."/$subdir";
	       

               $files = array_slice(scandir($dir), 2);
               if(count($files)) {
                  natcasesort($files);
                  $id = 8000;
                  foreach($files as $file) {
                    if($file != '.' && $file != '..' && is_dir( "$dir/$file")) {
                         #echo "checking $dir/$file/video.720.m3u8\n";
			 $m3u8_file = "video.720.m3u8";
			 if( !file_exists( "$dir/$file/$m3u8_file" ) )
			 {			 			   
			     #$m3u8 =  "$dir/$file/video.1080.m3u8";
			     $m3u8_file = "video.1080.m3u8";
			 }	
			 $streamFormat = "hls";  
			 $tstotal = 0;
			 if( file_exists( "$dir/$file/movie.mkv" ) )
			 {
				$m3u8_file = "movie.mkv";
				$streamFormat= "mkv";
				#$tstotal = shell_exec("mp4info '$dir/$file/movie.mkv' | grep video| perl -ne '/(\d+?)\.\d+ sec/ && print $1'");
                         }											 
			 else if( file_exists( "$dir/$file/movie.mp4" ) )
			 {
				$m3u8_file = "movie.mp4";
				$streamFormat= "mp4";
				$tstotal = shell_exec("mp4info '$dir/$file/movie.mp4' | grep video| perl -ne '/(\d+?)\.\d+ sec/ && print $1'");
                         }											 
			 if( file_exists( "$dir/$file/$m3u8_file" ) )
			 {

                              # count the ts files ... 720
			      if( $tstotal == 0 )
			      {
			         $tsfiles = array_slice( scandir("$dir/$file"), 2 );
                            
				foreach ($tsfiles as $ts ) 
			        {
                                   $ts = strtolower($ts );
                                   if(substr($ts, -3) == ".ts" )
                                   {
                                      $tstotal =$tstotal +10;
                                   }
                                }
			      }
                              $title = "title.jpeg";
			      if( file_exists( "$dir/$file/title_320x180.jpeg" ) )
			      {
                                   $title = "title_320x180.jpeg";
                              }
                              $imdb = NULL;
			      if( file_exists("$dir/$file/imdb.json" ) )
			      {
                                  $json=file_get_contents("$dir/$file/imdb.json");
				  $imdb=json_decode($json);
				  #echo $info->imdbRating, "\n";
			      }
                              $id = $id + 1;
                              generate_item( $id, $file, $m3u8_file, $title, $streamFormat, $imdb, $tstotal );

                         }
		    }
	          }
                }	
          ?>
 </feed>
