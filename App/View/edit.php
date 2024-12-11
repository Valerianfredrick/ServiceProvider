<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
<form id="edit-form" action="../update/<?php echo $service['id']; ?>" method="POST">
    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">

    <label for="Newname">New Name</label>
    <input type="text" name="name" value="<?php echo $service['name']; ?>">
    <br><br>

    <label for="Newdescription">New description</label>
    <input type="text" name="description" value="<?php echo $service['description']; ?>">
    <br><br>

    <label for="Newcost">New Cost</label>
    <input type="text" name="cost" value="<?php echo $service['cost']; ?>">
    <br><br>

    <label for="Newavailability">New Availability</label>
    <input type="text" name="availability" value="<?php echo $service['availability']; ?>">
    <br><br>

    <input type="submit" value="Submit" name="sub">
</form>
