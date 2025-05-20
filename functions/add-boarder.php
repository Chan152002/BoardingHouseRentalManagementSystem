<?php
include_once 'connection.php';

$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$start_date = $_POST['start_date'];
$room = $_POST['room'];
$type = $_POST['type'];

$target_dir = "";
 $target_dir . $fullname . basename($_FILES["name"]);
 $target_dir . $fullname . basename($_FILES["name"]);

$sql = "SELECT * FROM boarders WHERE fullname = :fullname OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../boarders.php?type=error&message=' . $fullname . ' is already exist or phone number is already exist');
    exit;
}


$sql = "INSERT INTO boarders (fullname, phone, sex, address, start_date, room, type) 
        VALUES (:fullname, :phone, :sex, :address, :start_date, :room, :type)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':type', $type);
$stmt->execute();

$boarder = $db->lastInsertId();

$sql = "SELECT rent FROM rooms WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $room);
$stmt->execute();
$rent = $stmt->fetchColumn();

$sql = "INSERT INTO payments (boarder, room, amount, total) VALUES (:boarder, :room, :amount, :total)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':boarder', $boarder);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':amount', $rent);
$stmt->bindParam(':total', $rent);
$stmt->execute();

$paymentId = $db->lastInsertId();

generate_logs('Adding boarder', $fullname . '| New boarder was added');
// header('Location: ../boarders.php?type=success&message=New boarder was added successfully');
header('Location: ../reciept.php?id=' . $paymentId);
exit;
