<?php
include_once 'functions/connection.php';

$sql = 'SELECT b.*, r.rent FROM `boarders` b
        INNER JOIN `rooms` r ON b.room = r.id';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><width="30" height="30" src="functions/"><?=$row['fullname']?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td><?= $row['type'] ?></td>
        <td>₱<?= $row['rent'] ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td class="text-center">
                     

            <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?=$row['id']?>">Remove</button>
        </td>
    </tr>

<?php
}
