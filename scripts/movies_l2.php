<?php
header("Content-Type: text/plain\n");
#header("Content-Type: text/html\n");phpinfo();
?>
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<feed>
<?php
#$url_user ="http://192.168.1.12/~as64720";
$url_user="http://192.168.47.129/~as64720";
$home_user="/home/as64720/public_html";
$subdir   = "movies";
$dir      = $home_user."/$subdir";
{
    # check arguments
    $ip    = $_SERVER['SERVER_ADDR'];
    $port  =$_SERVER['SERVER_PORT'];
    $context = $_SERVER['CONTEXT_PREFIX'];
    
    if( isset($ip) && isset($port) )
    {
	if( $port == "80" )
	{
	    $port = "";
	}
	else 
	{
	    $port =":$port";
	}
	$tmp=$_SERVER["CONTEXT_DOCUMENT_ROOT"];
	if( isset($tmp))
	{
	    $home_user = $tmp;
	}
	
	if( isset($context) )
	{
	    $context = preg_replace('/\/$/', '', $context);
	    $context = preg_replace('/^\//', '', $context);
	    $url_user = "http://$ip$port/$context";	    
	}
    }
    $tmp_dir = $_GET["dir"];
    if(isset($tmp_dir) )
    {
	$subdir = $tmp_dir;
    }
   # echo "IP=$ip home=$home_user\n";
    
}

function generate_item( $id, $movie_dir, $movie_file, $poster, $streamFormat, $imdb, $time, $series )
{
    global $url_user, $home_user, $subdir;
    # use only the name of the directory.
    $movie_dir_basename = basename($movie_dir);
    
    echo "	";
    echo "<item adImg=\"$url_user/movies/$movie_dir_basename/$poster\" ";
    echo " hdImg=\"$url_user/movies/$movie_dir_basename/$poster\" >\n";
    if(isset($imdb))
    {
	$imdbid = preg_replace( '/[^\d]+/', '', $imdb->imdbID)*1;
	
	echo "          <title>", $imdb->Title, "</title>\n";
	echo "          <description>", $imdb->Plot, "</description>\n";
	echo "          <contentId>$imdbid</contentId>\n"; 
    }
    else
    {
	echo "           <title>$movie_file</title>\n"; 
	echo "           <contentId>$id</contentId>\n"; 
    }
    echo "           <contentType>movie</contentType>\n"; 
    echo "           <contentQuality>HD</contentQuality>\n";
    echo "           <streamFormat>$streamFormat</streamFormat>\n";

   
    if( $series == 0 )
    { 
	$movie_bif = glob("$movie_dir/*.{bif}", GLOB_BRACE);
	if( count($movie_bif)>1)
	{
	    foreach ($movie_bif as $bif_path )
	    {
		$bif = basename( $bif_path );
		if( preg_match("/\SD/i",  $bif_path ) )
		{
		    echo "           <SDBifUrl>$url_user/$subdir/$movie_dir_basename/$bif</SDBifUrl>\n";
		}
		else
		{
		    echo "           <HDBifUrl>$url_user/$subdir/$movie_dir_basename/$bif</HDBifUrl>\n";
		}
	    }
	}
	else if( count($movie_bif)==1)
	{	
	    echo "           <SDBifUrl>$url_user/$subdir/$movie_dir_basename/", basename($movie_bif[0]), "</SDBifUrl>\n";
	    echo "           <HDBifUrl>$url_user/$subdir/$movie_dir_basename/", basename($movie_bif[0]), "</HDBifUrl>\n";
	}

	$movie_dir_srt = glob("$movie_dir/*.{srt}", GLOB_BRACE);
	if( count($movie_dir_srt)>0)
	{
	    $srt = basename( $movie_dir_srt[0] );
	    echo "           <SubTitleUrl>$url_user/$subdir/$movie_dir_basename/$srt</SubTitleUrl>\n";
	}
    }
    else
    {
	# check for matching name, that is the only way we can identify the 
	$name = preg_replace ('/\.[^.]+$/', '', $movie_file );
	#echo "NAME=$name\n"; 
	$movie_bif = glob("$movie_dir/*$name*.{bif}", GLOB_BRACE);
	foreach ($movie_bif as $bif_path )
	{
	    #echo "BIf $bif_path\n";
	    $bif = basename( $bif_path );
	    echo "           <SDBifUrl>$url_user/$subdir/$movie_dir_basename/", $bif, "</SDBifUrl>\n";
	    echo "           <HDBifUrl>$url_user/$subdir/$movie_dir_basename/", $bif, "</HDBifUrl>\n";
	    break;
	}
	$movie_dir_srt = glob("$movie_dir/*$name*.{srt}", GLOB_BRACE);
	if( count($movie_dir_srt)>0)
	{
	    $srt = basename( $movie_dir_srt[0] );
	    echo "           <SubTitleUrl>$url_user/$subdir/$movie_dir_basename/$srt</SubTitleUrl>\n";
	}
    }

    
    echo "           <media>\n";
    echo "              <streamFormat>$streamFormat</streamFormat>\n";
    echo "              <streamQuality>HD</streamQuality>\n";
    echo "              <streamBitrate>0</streamBitrate>\n";
    echo "              <streamUrl>$url_user/$subdir/$movie_dir_basename/$movie_file</streamUrl>\n";
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
    echo "	";
    echo "</item>\n";
}
?>
<?php
    
    $movies_dir = "$home_user/$subdir";
    $files = array_slice(scandir("$movies_dir"), 2);
    if(count($files)) 
    {
	natcasesort($files);
	$id = 8000;
	foreach($files as $file) 
	{
	    if($file == '.' || $file == '..' || !is_dir( "$movies_dir/$file")) 
	    {
		continue;
	    }
	    {
		# read files in directory.
		$movie_dir = "$movies_dir/$file";
		$movie_dir_contents = glob("$movie_dir/*.{mp4,m3u8,mkv}", GLOB_BRACE);
		natcasesort($movie_dir_contents);
		#echo "Total Movies: " , count($movie_dir_contents), "\n"; 
		$poster = "title.jpeg";
		if( file_exists( "$movie_dir/title_320x180.jpeg" ) )
		{
		    $poster = "title_320x180.jpeg";
		}
		$imdb = NULL;
		if( file_exists("$movie_dir/imdb.json" ) )
		{
		    $json=file_get_contents("$movie_dir/imdb.json");
		    $imdb=json_decode($json);
		    #echo $info->imdbRating, "\n";
		    $title = $imdb->Title;
		    
		}
		else
		{
		    $title = "";
		}
		$series = 0;
		if( count($movie_dir_contents)>1 )
		{
		    $series = 1;
		}
		if( $series )
		{
		    echo "    <itemSeries  title=\"", $title, "\" adImg=\"$url_user/$subdir/$file/$title\" ";
		    echo " hdImg=\"$url_user/$subdir/$file/$title\" >\n";
		}
		foreach ($movie_dir_contents as $movie_file_path )
		{
		    $movie_file = basename($movie_file_path);
		    #echo "File::: $movie_file\n";
		    if( preg_match("/\.mp4/i",  $movie_file ) )
		    {
			#echo "File: $movie_file is mp4\n";
			$streamFormat= "mp4";
			#$tstotal = shell_exec("mp4info '$movie_file_path' | grep video| perl -ne '/(\d+?)\.\d+ sec/ && print $1'");
			$cmd =  "mp4info '$movie_file_path' | grep video| perl -ne '/(\d+?)\.\d+ sec/ && print $1'\n";
			$tstotal = shell_exec( $cmd );
		    }
		    else if( preg_match("/\.mkv/i",  $movie_file ) )
		    { 
			$streamFormat= "mkv";
			$cmd =  "mkvinfo '$movie_file_path'  | grep Duration| perl -ne '/(\d+\.\d+)s/ && print $1'\n";
			$tstotal = shell_exec( $cmd );
		    }
		    else if( preg_match("/\.hls/i",  $movie_file ) )
		    { 
			$streamFormat= "mkv";
			$tstotal = count(glob("$movie_dir/*.ts", GLOB_BRACE))  * 10;
		    }	    
		    $id = $id + 1;
		  
		    generate_item( $id, $movie_dir, $movie_file, $poster, $streamFormat, $imdb, $tstotal, $series );	
		        		
		}
		if( $series )
		{
		    echo "    </itemSeries>\n";
		}	
	    }
	} # foreach files 
    }	
?>
</feed>
