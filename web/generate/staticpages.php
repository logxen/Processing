<?

require('../config.php');

$benchmark_start = microtime_float();



// make troubleshooting page
$source = CONTENTDIR."static";
$path = BASEDIR;


// update the files on the server via SVN


// look for the .subversion folder somewhere else

// otherwise will go looking for /home/root/.subversion or some other user

$where = CONTENTDIR . 'static';

putenv('HOME=' . CONTENTDIR);



`cd $where && /usr/bin/svn update`;

// make troubleshooting page
$source = CONTENTDIR."static/";
#$path = BASEDIR;
$page = new Page("Books", "Books");
$page->content(file_get_contents($source."books.html"));
writeFile('learning/books/index.html', $page->out());


// copy over the errata file for Processing: A Programming Handbook...

//copy($source.'processing-errata.txt', $path.'learning/books/processing-errata.txt');


$page = new Page("Copyright", "Copyright");
$page->content(file_get_contents($source."copyright.html"));

writeFile('copyright.html', $page->out());

// Copy over the images for the shop index
if (!is_dir($path.'shop')) { 
	
	mkdir($path.'shop', 0757); 

}

if (!is_dir($path.'shop/imgs')) { 
	
	mkdir($path.'shop/imgs', 0757); 

}

if (is_dir($path.'shop/imgs')) { 
	copydirr($source.'shop/imgs', $path.'shop/imgs', null, 0757, false);

}

$page = new Page("Shop", "Shop");
$page->content(file_get_contents($source.'shop/'."index.html"));
writeFile('shop/index.html', $page->out());




$benchmark_end = microtime_float();
$execution_time = round($benchmark_end - $benchmark_start, 4);

?>

<h2>Static page generation Successful</h2>
<p>Generated files in <?=$execution_time?> seconds.</p>