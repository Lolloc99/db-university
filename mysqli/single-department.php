<?php
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/Department.php";

// Prelevare le info del singolo dipartimento dal database
// Problematica per sql injection
// $id = $_GET["id"];
// $sql = "SELECT * FROM `departments` WHERE `id`=$id;";
// $result = $conn->query($sql);

// Adatta
// Preparazione dello statement
$statement = $conn->prepare("SELECT * FROM `departments` WHERE `id`=?");
$statement->bind_param('d', $id); //d sta per digit
$id = $_GET["id"];

// Esecuzione della query
$statement->execute();
$result = $statement->get_result();

$departments = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $current_department = new Department($row["id"], $row["name"]);
        $current_department->setContactData($row["address"], $row["phone"], $row["email"], $row["website"],);
        $current_department->$head_of_department = $row["head_of_department"];
        $departments[] = $current_department;
    }
} elseif ($result) {
    echo "Il dipartimento non è stato trovato";
} else {
    echo "Errore nella query";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singolo dipartimento</title>
</head>
<body>

    <a href="index.php">Ritorna all'elenco dipartimenti</a>

    <?php foreach ($departments as $department) { ?>
        <h1><?php echo $department->name;?></h1>
        <p><?php echo $department->head_of_department;?></p>

        <h2>Contatti</h2>
        <ul>
            <?php foreach ($department->getContactAsArray() as $key => $value) { ?>
                <li><?php echo "$key: $value" ?></li>
            <?php } ?>
        </ul>
    <?php } ?>


</body>
</html>