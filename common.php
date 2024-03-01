<?
date_default_timezone_set("Asia/Kuala_Lumpur");
session_start();
$db = mysqli_connect("localhost", "catmgr_uoa", "yJS0UpBWZkJQ4Lpj", "catmgr_uoa") or die("Cannot connect to database.");
mysqli_set_charset($db, "utf8");

$session_pfx = "catmgr_uoa_";

$site_name = "UOA";
$company_name = "UOA";
//$mail_sender = "noreply@cita-malaysia.org";
//$mail_recipient = "info@rubysoft.com.my";
//$site_url = "https://cita-malaysia.org/";
$mail_sender = "noreply@rubysb.com";
$mail_recipient = "info@rubysoft.com.my";
$site_url = "http://rubysb.com/uoa/";

function hsc($s)
{
	return htmlspecialchars($s, ENT_QUOTES);
}
function frmp($s)
{
	if (isset($_POST[$s])) return hsc($_POST[$s]);
	else return "";
}
function frmg($s)
{
	if (isset($_GET[$s])) return hsc($_GET[$s]);
	else return "";
}
function frm($s)
{
	if (frmp($s) != "") return frmp($s);
	else if (frmg($s) != "") return frmg($s);
	else return "";
}
function frmr($s)
{
	if (isset($_POST[$s]) && $_POST[$s] != "") return $_POST[$s];
	else return "";
}
function clean($s)
{
	global $db;
	return mysqli_real_escape_string($db, stripslashes($s));
}

function cbx($s)
{
	return ($s == "on" ? 1 : 0);
}
function rvd($s)
{
	$d = "-";
	if ($s == "") return "";
	$r = explode($d, $s);
	if (sizeof($r) != 3) return "";
	return $r[2] . $d . $r[1] . $d . $r[0];
}
function pad($s, $c, $l)
{
	while (strlen($s) < $l) {
		$s = $c . $s;
	}
	return $s;
}
function xxx($s)
{
	return preg_replace('[a-zA-Z0-9]', 'x', $s);
}
function rnd($l)
{
	$s = "abcdefghjkmnpqrstuvwxyz0123456789";
	$p = "";
	for ($i = 0; $i < $l; $i++) {
		$p .= substr($s, rand(0, strlen($s) - 1), 1);
	}
	return $p;
}
function lnbr($s)
{
	return str_replace("\n", "<br/>", $s);
}
function go($u)
{
	echo "<meta http-equiv='REFRESH' content='0; URL=" . $u . "'>";
	exit();
}
function pageurl()
{
	return "http" . ($_SERVER["HTTPS"] == "on" ? "s" : "") . "://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_PORT"] != "80" ? ":" . $_SERVER["SERVER_PORT"] : "") . $_SERVER["REQUEST_URI"];
}
function genap($s)
{
	$d = $s * 100;
	$m = $d % 10;
	if ($m == 1 || $m == 6) {
		$d -= 1;
	}
	if ($m == 2 || $m == 7) {
		$d -= 2;
	}
	if ($m == 3 || $m == 8) {
		$d += 2;
	}
	if ($m == 4 || $m == 9) {
		$d += 1;
	}
	return dfd($d / 100);
}
function img($s)
{
	return str_replace('../', '', $s);
}

function mq($s)
{
	global $db;
	return mysqli_query($db, $s);
}
function mfa($s)
{
	return mysqli_fetch_array($s);
}
function mfas($s)
{
	return mysqli_fetch_assoc($s);
}
function mnr($s)
{
	return mysqli_num_rows($s);
}

function set($s, $v)
{
	global $session_pfx;
	$_SESSION[$session_pfx . $s] = $v;
}
function get($s)
{
	global $session_pfx;
	if (isset($_SESSION[$session_pfx . $s])) return $_SESSION[$session_pfx . $s];
	else return "";
}
function unsetset($s)
{
	global $session_pfx;
	unset($_SESSION[$session_pfx . $s]);
}

function setc($s, $v)
{
	global $session_pfx;
	setcookie($session_pfx . $s, $v, (time() + 60 * 60 * 24 * 365));
}
function getc($s)
{
	global $session_pfx;
	if (isset($_COOKIE[$session_pfx . $s])) return $_COOKIE[$session_pfx . $s];
	else return "";
}

function now()
{
	return date('Y-m-d H:i:s');
}
function sdf($t)
{
	return date('d-M-Y', strtotime($t));
}
function sdtf($t)
{
	return date('d-M-Y, h:i a', strtotime($t));
}
function sdfnm($t)
{
	return date('d-m-Y', strtotime($t));
}
function stf($t)
{
	return date('h:i a', strtotime($t));
}
function sdfd($t)
{
	return date('d', strtotime($t));
}
function sdfm($t)
{
	return date('m', strtotime($t));
}
function sdfy($t)
{
	return date('Y', strtotime($t));
}

function moddate($s, $v)
{
	return date('Y-m-d', strtotime($v, strtotime($s)));
}

function dfi($s)
{
	return number_format($s, 0);
}
function dfd($s)
{
	return number_format($s, 2);
}

function isalphanum($s)
{
	return !preg_match('/[^a-zA-Z0-9_]/', $s);
}
function chk($s)
{
	return (strlen($s) >= 4 && strlen($s) <= 16 && isalphanum($s));
}
function isdate($s)
{
	$d = "-";
	if ($s == "") return 0;
	$r = explode($d, $s);
	if (sizeof($r) != 3) return 0;
	return checkdate($r[1], $r[0], $r[2]);
}
function isnulldate($s)
{
	return (!isset($s) || $s == "" || $s == "00-00-0000" || $s == "0000-00-00" || $s == "00-00-0000 00:00:00" || $s == "0000-00-00 00:00:00");
}
function isemail($s)
{
	$a = "a-z0-9-";
	$r = "/^[_" . $a . "]+(\.[_" . $a . "]+)*@[" . $a . "]+(\.[" . $a . "]+)*(\.[a-z]{2,10})$/i";
	return (preg_match($r, $s));
}
function isphone($s)
{
	return !(preg_match('/[^0-9()\-]/', $s));
}

function isurl($s)
{
	return preg_match('|^[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $s);
}
function isint($s)
{
	return !preg_match('/[^0-9,]/', $s);
}
function isdbl($s)
{
	return (!preg_match('/[^0-9.,]/', $s) && substr_count($s, ".") < 2);
}
function cint($s)
{
	return (isint($s) ? trim(str_replace(",", "", $s)) + 0 : 0);
}
function cdbl($s)
{
	return (isdbl($s) ? trim(str_replace(",", "", $s)) + 0 : 0.00);
}
function cbool($s)
{
	$s = strtolower($s);
	return (($s == 'y' || $s == 'yes' || $s == 'true' || $s == '1' || $s == 'on') ? 1 : 0);
}
function epfx($e, $s)
{
	return (($e != "" ? "<br/>" : "") . "&#149;&nbsp; " . $s);
}
function upfx($u, $s)
{
	return (($u != "" ? "<br/>" : "") . "&#149;&nbsp; " . $s);
}

function getimg($s)
{
	return str_replace("../", "", $s);
}

function pr($s)
{
	echo "<pre>";
	print_r($s);
	echo "</pre>";
}

function doinsert($table = "", $values = array())
{
	$sql = "INSERT INTO " . $table . " ";
	$ks = "";
	$vs = "";
	$w = "";
	foreach ($values as $k => $v) {
		$v = clean($v);
		$ks .= ($ks == "" ? "" : ", ") . " `" . $k . "` ";
		$vs .= ($vs == "" ? "" : ", ") . " '" . $v . "' ";
		$w .= ($w == "" ? "" : " AND ") . " `" . $k . "`='" . $v . "'";
	}

	$sql .= " (" . $ks . ") VALUES (" . $vs . ")";
	if (mq($sql)) {
		$sql = "SELECT id FROM " . $table . " WHERE id > 0 AND " . $w;
		$r = mfa(mq($sql));
		return $r[0];
	}
	return false;
}

function doupdate($table = "", $values = array(), $cond = array())
{
	$sql = "UPDATE `" . $table . "` SET ";
	$vs = "";
	foreach ($values as $k => $v) {
		$v = clean($v);
		$vs .= ($vs == "" ? "" : ", ") . " `" . $k . "`='" . $v . "'";

		if (!empty($cond["AND"]))
			foreach ($cond["AND"] as $k2 => $v2) $cond["AND"][$k2] = str_replace("#" . $k . "#", $v, $v2);
		if (!empty($cond["OR"]))
			foreach ($cond["OR"] as $k2 => $v2) $cond["OR"][$k2] = str_replace("#" . $k . "#", $v, $v2);
	}
	$sql .= $vs . " WHERE id > 0 ";
	$w = "";
	if (!empty($cond)) {
		if (!empty($cond["AND"])) $w .= " AND " . implode(" AND ", $cond["AND"]);
		if (!empty($cond["OR"])) $w .= " OR " . implode(" OR ", $cond["OR"]);
	}

	$sql .= $w;
	return mq($sql);
}


if (frm("y") == 1) {
	set("y", 1);
}
$y = get("y");
if (frm("z") == 1) {
	set("z", 1);
}
$z = get("z");

$this_file = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/") + 1);
if (strpos($this_file, "?") !== false) {
	$this_file = substr($this_file, 0, strpos($this_file, "?"));
}

$this_page = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$page = frm("page");
