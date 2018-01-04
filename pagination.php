<?php
require_once('config.php');
$countQ = mysqli_query($con,"SELECT COUNT(id) as total FROM student");
$row_cnt = mysqli_fetch_assoc($countQ);
$totalrecord = $row_cnt['total'];
$perpage = 10;
$pages = ceil($totalrecord/$perpage);
$startLimit = 0;
if(isset($_GET['page'])){
    $startLimit = ($_GET['page']-1)*$perpage;
}
$getQuery = mysqli_query($con,"SELECT * FROM student LIMIT $startLimit, $perpage");
while($rowd = mysqli_fetch_assoc($getQuery)){
echo '<pre>';
print_r($rowd);
}

for($i=1;$i<=$pages;$i++){ ?>
    <a href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a>
<?php
}
?>