<?php ob_start(); ?>
<?php
$conn=mysql_connect('localhost','root','') or die(mysql_error());
mysql_select_db('socialnetworking', $conn) or die(mysql_error());;
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="events.css" />
<title>Events</title>
</head>

<body>
<h1><a href="index.php"><img src='2.jpg' href="index.php"/></a> Social Networking </h1><br>
<?php
if(!isset($_GET['id']))	{
echo '<h4> Search Event </h4>';
echo '<form action="events.php" method="post">
Search <input type = "text" name="search_event" />
<input type="submit" value="search">
</form>';

if(isset($_COOKIE[id])){
echo '<h4>Add event</h4>';
echo '<form action="addEvent.php" method="post">
Name <input type="text" name="name"/>
Date and Time <input type="text" name="time" value="yyyy-mm-dd hh:mm:ss"/>
Location <input type="text" name="location"/>
Description <input type="text" name="description">
<input type="submit" value="Add">
</form>
';
}
echo '<h4>Events happening right now are:</h4>';
if(isset($_POST[search_event]))
$tt="name like '%{$_POST[search_event]}%'";
else
$tt=1;
$res=mysql_query("select name, id from event where {$tt}");
echo '<ul>';
while($row=mysql_fetch_array($res)){
$ss="events.php?id={$row['id']}";
echo "<a href=\"{$ss}\"><li>".$row['name']."</li></a>";
}
echo '</ul>';
}else{
$res=mysql_query("select * from event where id = {$_GET['id']}");
$row=mysql_fetch_array($res);
echo '<ul>';
echo '<li>'."Name: {$row[1]}".'</li>';
echo '<li>'."Time: {$row[2]}".'</li>';
echo '<li>'."Location: {$row[3]}".'</li>';
echo '<li>'."Description: {$row[4]}".'</li>';
echo '</ul>';
echo '<h4>People attending the event are:</h4>';
$res=mysql_query("select username, a.id from attends a, person b where a.id=b.id and a.event_id = {$_GET['id']}");
echo '<ul>';
while($row=mysql_fetch_array($res)){
echo  "<a href=\" profile.php?id={$row[1]} \">".'<li>'."{$row[0]}".'</li>'."</a>";
}
echo '</ul>';
}
if(isset($_COOKIE['id'])&&isset($_GET['id'])){
$res=mysql_query("select username from attends a, person b where a.id=b.id and a.event_id = {$_GET['id']} and b.id={$_COOKIE['id']}");
$row=mysql_fetch_array($res);
if(isset($row[0])){
echo '<a href="attendEvent.php?id='."{$_GET[id]}\">".'<h4>You are Attending this event, click to unattend'.'</h4></a>';
}
else{
echo '<a href="attendEvent.php?id='."{$_GET[id]}&at=1\">".'<h4>You are not Attending this event, click to Attend'.'</h4></a>';
}
}
else if(isset($_GET['id']))
echo '<a href="index.php"><h4>Please login first to attend</h4></a>';
?>
<?php
if(isset($_GET[id])){
$res=mysql_query("select * from event where id={$_GET[id]}");
$row=mysql_fetch_array($res);
if($row[5]==$_COOKIE[id])
echo "<a href=\"deleteEvent.php?id={$_GET[id]}\"><h4>You own this event, click to delete </h4></a>";
}
?>
</body>


</html>