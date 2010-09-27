<?php

if (!$_MIDGARD['user']) {
	die('No User, exiting!');
}

if (   !isset($_POST)
	|| !is_array($_POST)
	|| !isset($_POST['todoitem_guid'])) {
	die('No Post or guid, exiting!');
}

$comment = new net_nehmer_comments_comment();

$comment->objectguid = $_POST['todoitem_guid'];
if (isset($_POST['title'])) {
	$comment->title = $_POST['title'];
} else {
	$comment->title = '';
}

if (isset($_POST['content'])) {
	$comment->content = $_POST['content'];
} else {
	$comment->content = '';
}

if (isset($_POST['subscribe'])) {
	$comment->subscribe = 1;
} else {
	$comment->subscribe = 0;
}

if (   isset($_SERVER["HTTP_X_FORWARDED_FOR"])
    && !empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
    $comment->ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
    $comment->ip = $_SERVER['REMOTE_ADDR'];
}

$comment->status = 5;
$comment->author = $_MIDCOM->auth->user->name;

$comment->create();

$_MIDCOM->relocate($_POST['return_url']);
?>