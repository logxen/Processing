<?php
$PAGE_TITLE = "Mobile Processing";
$PAGE_HEAD = '<link rel="alternate" media="handheld" href="http://wapmp.at/" />';

require 'header.inc.php';
?>
<div class="column2x" style="width: 300px; clear: left">
    <img src="exhibition/images/header.png"><br>
<br>
<br>
<?php 
$lockfp = fopen('exhibition/curated/lockfile', 'r');
if ($lockfp !== FALSE) {
    if (flock($lockfp, LOCK_SH)) {
        require 'exhibition/curated/generated/home.inc.php';
    }
}
?>
<br>
<br>
<br>
<a href="learning/"><img src="images/examples.png"></a><br>
<br>
<br>
<?php 
$lockfp = fopen('learning/lockfile', 'r');
if ($lockfp !== FALSE) {
    if (flock($lockfp, LOCK_SH)) {
        require 'learning/generated/home.inc.php';
    }
}
?>
</div>
<div class="column" style="width: 400px">
    <br>
    Mobile Processing is an open source programming environment for people who want to design and prototype software for mobile phones. It is based on and shares the same design goals as the open source <a href="http://processing.org/">Processing</a> project. Sketches programmed using Mobile Processing run on Java Powered mobile devices.<br>
    <br>
    <br>
    <br>
    <img src="images/updates.png"><br>
    <br>
    <br>
<?php
$fp = fopen("discourse/Boards/news.txt", 'r');
if ($fp) {
  $i = 0;
  while (!feof($fp) && ($i < 3)) {
    $line = fgets($fp);
    $tokens = explode("|", $line);
    $id = $tokens[0];

    $fp2 = fopen("discourse/Messages/". $id .".txt", 'r');
    $line = fgets($fp2);    
    $tokens = explode("|", $line);
    $line = null;
    fclose($fp2);

    $ts = strtotime($tokens[3]);
    echo "<i>". date("j M Y", $ts) ."</i><br />";
    echo $tokens[0] ."<br />";
    echo substr($tokens[8], 0, strpos($tokens[8], "<br>")) ."<br />";
    echo "<a href=\"discourse/YaBB.cgi?board=news;action=display;num=". $id ."\">Read more...</a><br /><br />";
    $tokens = null;
    $i++;
  }
  fclose($fp);
}
?>
    <br />
    <a href="discourse/YaBB.cgi?board=news">Previous Updates</a> \ <a href="http://feeds.feedburner.com/MobileProcessing" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon16x16.png" alt="" style="vertical-align:bottom;border:0"/></a>&nbsp;<a href="http://feeds.feedburner.com/MobileProcessing" rel="alternate" type="application/rss+xml">Feed</a><br />
    <br />
    <br />
    <img src="images/happenings.png"><br>
    <br>
    <br>
    <i>28 Apr 2007</i><br>
Mobile Processing Lecture at FLISOL2007 by Marlon J. Manrique.<br /><a href="http://installfest.info/FLISOL2007/Colombia/Manizales">More info</a><br />
    <br />
    <i>6 May 2007</i><br>
    Mobile Processing Workshop at Mobilized! NYC by Francis Li.<br /><a href="http://www.mobilizednyc.org/">More info</a><br>
    <br>
</div>
<?php
require 'footer.inc.php';
?>