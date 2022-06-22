<?php
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/Department.php";

// Query
$sql = "SELECT `id`, `name` FROM `departments`;";
$result = $conn->query($sql);

$departments = [];

// Controllo se è presente il risultato e che non sia vuoto
if ($result && $result->num_rows > 0) {
    // abbiamo dei risultati della query
    while ($row = $result->fetch_assoc()) {
        $current_department = new Department($row["id"], $row["name"]);
        $departments[] = $current_department;
    }

} elseif ($result) {
    // query funzionante ma priva di risultati
} else {
    // query non funzionante
    // c'è un errore di sintassi nella query
    echo "Query error";
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista robe</title>
</head>
<body>
    
    <h1>Lista di dipartimenti</h1>

    <?php foreach ($departments as $department) { ?>
    <div>
        <h2><?php echo $department->name; ?></h2>
        <a href="single-department.php?id=<?php echo $department->id?>">Vedi Informazioni</a>
    </div>
    <?php } ?>

</body>
</html>