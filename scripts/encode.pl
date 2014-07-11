#!/usr/bin/perl -w
#
#
use strict;
use threads;
use Getopt::Long;
#ffmpeg -y   -i $* -c:a libvo_aacenc -ac 1 -b:a 32k -ar 22050 -c:v libx264 -pix_fmt yuv420p -profile:v baseline -level 13 -r 50 -g 36 -f hls -hls_time 10 -hls_list_size 999   -b:v 1.5M -s 1280x720 video.720.m3u8

sub usage()
{
    print STDERR "$0 --bif --ts|--mp4 [-resolution 1080|720*] <.. files to convert >\n";
    die "usage:";
}

my $generate_bif = undef;
my $opt_resolution = "720";
my $generate_ts = undef;
my $generate_mp4 = undef;
GetOptions( "help" => sub { usage(); },
	    "bif"  => \$generate_bif,
	    "ts"   => \$generate_ts,
	    "mp4"   => \$generate_mp4,
	    "resolution:s" => \$opt_resolution
    ) || usage();

my $arg = "";
my $arg2 = "";
foreach my $a (@ARGV )
{
    $arg .= "-i '$a' ";
    $arg2 .= " '$a' ";
}

my $tid =undef;
if( defined($generate_bif) )
{
    #die "here in sie";
    $tid = async ( sub { system "biftool.py $arg2 trick"; } ); 
}


my $resolution = "1280x720";
my $m3u8_file  = "video.720.m3u8";
if( defined($opt_resolution) )
{
    if( $opt_resolution eq "1080")
    {
	$m3u8_file = "video.1080.m3u8";
	$resolution = "1920x1080";
    }
    elsif ( $opt_resolution =~ /^\d+x\d+$/ )
    {
	$m3u8_file = "video.1080.m3u8";
	$resolution = $opt_resolution;
    }
}
#system "ffmpeg -y   $arg -c:a libvo_aacenc -ac 1 -b:a 32k -ar 22050 -c:v libx264 -pix_fmt yuv420p -profile:v baseline -level 13 -r 50 -g 36 -f hls -hls_time 10 -hls_list_size 999   -b:v 3M -s $resolution1280x720 video.720.m3u8";

if(defined($generate_ts) )
{
    system "ffmpeg -y   $arg -c:a libvo_aacenc -ac 1 -b:a 32k -ar 22050 -c:v libx264 -pix_fmt yuv420p -profile:v baseline -level 13 -r 50 -g 36 -f hls -hls_time 10 -hls_list_size 999   -b:v 3M -s $resolution $m3u8_file";
}
if(defined($generate_mp4) )
{
	#system "ffmpeg -y   $arg -c:a libvo_aacenc -ac 1 -b:a 32k -ar 22050 -c:v libx264 -pix_fmt yuv420p -profile:v baseline -level 13 -r 50 -g 36 -f mp4  -b:v 3M -s $resolution video.mp4";
	#system "ffmpeg -y   $arg -c:a libvo_aacenc -ac 1 -b:a 32k -ar 22050  -f mp4  -b:v 3M -s $resolution video.mp4";
	#my $cmd = "ffmpeg -y $arg -vcodec libx264 -threads 0 -f mp4 -y -c:a libvo_aacenc  -ab 128k -ac 2 -preset slow -profile:v high -level 4 -crf 20 -s $resolution movie.mp4";
#    my $cmd = "ffmpeg -y $arg -vcodec libx264 -threads 0 -f mp4 -y -ab 128k -ac 2 -preset slow -profile:v high -level 4 -crf 20 -s $resolution movie.mp4";
    my $cmd = "ffmpeg -y $arg -vcodec libx264 -threads 0 -f mp4 -y -c:a libvo_aacenc -ab 32k -ac 2 -preset slow -profile:v high -level 4 -crf 20    -b:v 3M -s $resolution movie.mp4";
    print $cmd, "\n";
    system $cmd;
}

  #837  ffmpeg -i ../movies/The.Wolf.of.Wall.Street/video.720100.ts -r 1 -t 1 -f image2 -s 320x170 ../movies/The.Wolf.of.Wall.Street/title.jpeg
  #
  #
 if(defined($tid))
 {
     $tid->join();
 }
