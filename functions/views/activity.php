<?php
include_once 'functions/connection.php';

$sql = 'SELECT * FROM logs';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();


foreach ($results as $row) {
 
    $sql = 'SELECT username FROM users WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $row['user_id']);
    $stmt->execute();
    $user = $stmt->fetch();
    ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
    
            <td><?php echo $row['type'] ?></td>
            <td><?php echo $row['logs'] ?></td>
            <td><?php echo $row['created_at'] ?></td>

        <?php
        
        ?>

    </tr>
        
<?php
}
