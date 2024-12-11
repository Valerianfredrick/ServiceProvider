
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="../assets/css/task.css">
</head>
<body>
    <h1>List of Services</h1>

    <?php if (!empty($services)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo ($service['name']); ?></td>
                        <td><?php echo ($service['description']); ?></td>
                        <td><?php echo ($service['cost']); ?></td>
                        <td><?php echo ($service['availability']); ?></td>
                        <td> <a href="../CreateController/edit/<?php echo $service['id']; ?>">Edit</a>
                        <a href="../CreateController/delete/<?php echo $service['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                    </tr>
                    </td>
                        
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No services available.</p>
    <?php endif; ?>

</body>
</html>
