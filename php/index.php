<?php
$connection = new Mongo("mongodb://localhost/");

$db = $connection->dummycan;

$collection = $db->students;

$grid = $db->getGridFS();
?>

<form method="post" enctype="multipart/form-data">
<p><label for="name">Name:</label> <input type="text" name="name"></p>
<p><label for="id">ID:</label> <input type="text" name="id"></p>
<p><label for="photo">Photo:</label><input type="file" name="photo"></p>
<input type="submit" value="Upload Data">
<br />
<?php
$name = $_POST['name'];
$id = $_POST['id'];
$photo = $_FILES['photo']['name'];
$photo_id = $grid->storeUpload('photo',$photo);
$obj = array('name' => $name, 'id' => $id, 'photo' => $photo_id);

if ($collection->findOne(array('id' => $obj['id'])) == '') {
    $collection->insert($obj);
} else {
    print "This ID already exists.<br />";
}

/*
$cursor = $collection->find();

foreach ($cursor as $result) {
    echo $result['name'];
    echo $result['id'];
}
 */
echo $grid->findOne(array('_id' => $photo_id))->getBytes();


?>
