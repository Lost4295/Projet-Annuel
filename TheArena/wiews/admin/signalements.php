<?php require 'header.php';

    $db = connectToDB();
    $queryPrepared = $db->query("SELECT * FROM " . PREFIX . "user_reports");
    $reports = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $queryPrepared = $db->query("SELECT * FROM " . PREFIX . "users");
    $users = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

    print_r($reports);
    print_r($users);
?>
<h1>Signalements</h1>
<table class="table table-hover table-bordered w-100" aria-describedby="reports-table">
    <thead>
        <th>Nom</th>
        <th>Type</th>
        <th>Contenu</th>
        <th>Actions</th>
    </thead>
    
    <tbody>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="btn btn-primary placeholder col-10"></span></td>
        </tr>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class=" btn btn-primary placeholder col-10"></span></td>
        </tr>
        <tr>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="placeholder col-10"></span></td>
            <td><span class="btn btn-primary placeholder col-10"></span></td>
        </tr>
    </tbody>
</table>

<?php include 'footer.php'?>
