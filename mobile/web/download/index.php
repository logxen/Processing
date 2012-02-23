<?php
$PAGE_TITLE = "Mobile Processing &raquo; Download";

require '../header.inc.php';
?>
<img src="images/header.png"><br>
&nbsp;
<ol>
  <li><b>Windows</b>: Install the latest version of Java on your computer.<br><br>
<a href="http://java.com/"><img border="0" src="images/java.png"></a><br>
<a href="http://java.com/">http://java.com/</a><br><br>Choose <b>Download Now</b> to begin or <b>Verify Installation</b> to check if it is already installed on your computer.<br><br></li>
  <li>Download and install a Wireless Toolkit (WTK) for building mobile phone applications. Note the location of the installation.<br><br>
<b>Windows</b>: Sun Java Wireless Toolkit for CLDC<br>
<a href="http://java.sun.com/products/sjwtoolkit/">http://java.sun.com/products/j2mewtoolkit/</a><br><br>
<b>Mac OS X</b>: Mpowerplayer SDK<br>
<a href="http://www.mpowerplayer.com/products-sdk.php">http://www.mpowerplayer.com/products-sdk.php</a><br>&nbsp;</li>
  <li>Download and install the Mobile Processing IDE.<br><br>
<a href="mobile-0007-windows.zip"><img border="0" src="images/windows.png"></a><a href="mobile-0007-macosx.zip"><img border="0" src="images/mac.png"></a><br><br>
0007&nbsp;&nbsp|&nbsp;&nbsp;13 04 2008&nbsp;&nbsp;<a href="mobile-0007-windows.zip">Windows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0007-macosx.zip">Mac OS X</a><br><br>
<a href="revisions.txt">Changes</a> for the latest release as well as core and library API updates.<br><br>
  </li>
  <li>Run Mobile Processing. Choose <b>Preferences</b> from the main drop-down menu. In the <b>Preferences</b> dialog box, go to the <b>Mobile</b> tab, and enter the location of the WTK.<br>
<br></li>
<li>From the <b>Help</b> menu, choose <b>Check for updates...</b> to check for and automatically download the latest versions of the core API and libraries over the Internet. Current versions:<br /><br />
<?php
function parse_date($line) {
    //// remove comment #
    $line = substr($line, 1);
    //// move time and timezone to end of string so it can be parsed
    $pos = strrpos($line, " ");
    $year = substr($line, $pos);
    $line = substr($line, 0, $pos);
    $pos = strrpos($line, " ");
    $tz = substr($line, $pos);
    $line = substr($line, 0, $pos);
    $pos = strrpos($line, " ");
    $line = substr($line, 0, $pos) . $year . substr($line, $pos) . $tz;
    //// return formatted date
    return date("d m Y", strtotime($line));
}
$build = array();
$fp = fopen('mobile.properties', 'r');
if ($fp) {
    while (!feof($fp)) {
        $line = fgets($fp);
        if ($line[0] == "#") {
            $date = parse_date($line);
        } else if (strstr($line, "build=") !== false) {
            $build['core'] = substr($line, strpos($line, "=") + 1);
        }
    }
    fclose($fp);
}
$fp = fopen("docs.properties", 'r');
if ($fp) {
    while (!feof($fp)) {
        $line = fgets($fp);
        if ($line[0] == "#") {
            $date = parse_date($line);
        } else if (strstr($line, "build=") !== false) {
            $build['documentation'] = substr($line, strpos($line, "=") + 1);
        }
    }
    fclose($fp);
}
$fp = fopen('libraries/version.properties', 'r');
if ($fp) {
    while (!feof($fp)) {
        $line = fgets($fp);
        if ($line[0] == "#") {
            $date = parse_date($line);
        } else if (strpos($line, "=") !== false) {
            $pos = strpos($line, "=");
            $build[substr($line, 0, $pos)] = trim(substr($line, $pos + 1));
        }
    }
    fclose($fp);
}
foreach ($build as $lib => $ver) {
    echo sprintf("%04d", $ver) . "&nbsp;&nbsp;". ucfirst($lib) ."<br />";
}
?>
<br>
<br>
<br>
<br>
Previous IDE releases:<br><br>
0006 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;04 05 2007&nbsp;&nbsp;<a href="mobile-0006-expert.zip">Windows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0006.zip">Mac OS X</a><br>
0005 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;18 05 2006&nbsp;&nbsp;<a href="mobile-0005-expert.zip">Windows</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0005.dmg">Mac OS X</a><br>
0004 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;10 05 2006&nbsp;&nbsp;Windows <a href="mobile-0004.zip">Standard</a> or <a href="mobile-0004-expert.zip">without Java</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0004.dmg">Mac OS X</a><br>
0003 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;29 01 2006&nbsp;&nbsp;Windows <a href="mobile-0003.zip">Standard</a> or <a href="mobile-0003-expert.zip">without Java</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0003.dmg">Mac OS X</a><br>
0002 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;20 01 2006&nbsp;&nbsp;Windows <a href="mobile-0002.zip">Standard</a> or <a href="mobile-0002-expert.zip">without Java</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0002.dmg">Mac OS X</a><br>
0001 ALPHA&nbsp;&nbsp|&nbsp;&nbsp;08 11 2005&nbsp;&nbsp;Windows <a href="mobile-0001.zip">Standard</a> or <a href="mobile-0001-expert.zip">without Java</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mobile-0001.dmg">Mac OS X</a>
  </li>
</ol>
<?php
require '../footer.inc.php';
?>
