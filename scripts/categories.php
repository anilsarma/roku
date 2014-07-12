<?php
header("Content-Type: text/plain\n");
?>
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<categories>

  <!-- banner_ad: optional element which displays an at the top level category screen -->
  <banner_ad sd_img="http://rokudev.roku.com/rokudev/examples/videoplayer/images/missing.png" 
	     hd_img="http://192.168.1.12/~as64720/hls/2012/00042/title.jpeg"/>
  
  
  <category title="Movies" description="Auto Public Movies" sd_img="" hd_img="http://192.168.1.12/~as64720/movies/home_movies.jpeg">
    <categoryLeaf title="Movies" description="" feed="http://192.168.1.12/~as64720/php-bin/movies_l2.php"/>
    <categoryLeaf title="Songs" description="" feed="http://192.168.1.12/~as64720/php-bin/movies_l2.php?dir=songs"/>
  </category>

  <!--category title="Movies" description="Public Movies" sd_img="" hd_img="http://192.168.1.12/~as64720/movies/home_movies.jpeg">
    <categoryLeaf title="Movies" description="" feed="http://192.168.1.12/~as64720/video/movies.xml"/>
  </category-->
  
  <category title="Home Videos" description="Home Videos" sd_img="" hd_img="http://192.168.1.12/~as64720/hls/2011/20110122.NJ/00001/title.jpeg">
    <?php
       $dir_root = "/home/as64720/public_html";
       $url_root = "http://192.168.1.12/~as64720";
       $subdir = "hls";
       $dir = $dir_root."/$subdir";
       
       
       $files = array_slice(scandir($dir), 2);
       if(count($files)) 
       {
            natcasesort($files);
	    foreach($files as $file) 
	    {
		if($file != '.' && $file != '..') 
		{
		    echo "		";
		    echo "<categoryLeaf title=\"Home Movies $file\" description=\"\" feed=\"$url_root/php-bin/getm3u8.php?album=$subdir/$file\" />\n";
		}
	    }
       }	
       ?>
  </category>
  <category title="Home Videos Non Generated" description="Home Videos" sd_img="" hd_img="http://192.168.1.12/~as64720/hls/2011/20110122.NJ/00001/title.jpeg">
    <categoryLeaf title="Home Movies 2010" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2010.xml" />
    <categoryLeaf title="Home Movies 2011" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2011.xml" />
    <categoryLeaf title="Home Movies 2011 September" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2011_20110122.xml" />
    <categoryLeaf title="Home Movies 2012" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2012.xml" />
    <categoryLeaf title="Home Movies 2013" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2013.xml" />
    <categoryLeaf title="Home Movies 2014" description="" feed="http://192.168.1.12/~as64720/video/home_movies_2014.xml" />
  </category>
  

 </categories>
