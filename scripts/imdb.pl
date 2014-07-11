#!/usr/bin/perl -w
#


my $imdb =  `curl http://www.omdbapi.com/?i=$ARGV[0]`;
chomp $imdb;
my %json;
if ( $imdb =~ /\{(.+)?\}/)
{
        my $a = $1;
        my $b = $a;
        my @t = split/,/, $a;
        while ( $b =~ s/"(.+?)":"(.+?)"[,]?//)
        {
                my ($name, $value) = ($1, $2);
                $json{$name} = $value;
        }
}
my $dir = "/home/as64720/public_html/movies";
my $title = $json{'Title'};
if(defined($title))
{
	$title =~ s/[:\s+]/\./g;
	$title =~ s/\.+/\./g;
	print "Directoy .. $title\n";
	$dir = "$dir/$title/";
	if( !-d "$dir" )
	{
		 system "mkdir -p $dir";

	        if( !-d "$dir" )
		{
			 die "cannot create $dir";
		 }

	}
}
else
{
	 print STDERR "title not found in IMDB\n";
	 exit(1);
}
print STDERR "using directory $dir\n";


open FILE, ">$dir/imdb.json";
print FILE $imdb;
close FILE;

my $poster = $json{'Poster'};
if( defined($poster) && !-f "$dir/title_320x180.jpeg" )
{
	system "cd $dir;curl $poster > title.jpeg";
	system "cd $dir;make_title.pl title.jpeg";
}
