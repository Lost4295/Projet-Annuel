<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->

<?php require $_SERVER['DOCUMENT_ROOT'].'/core/header.php'; 
$db= connectToDB();
$query= $db->query("Select id, name,description, date_creation from ".PREFIX."forums ORDER BY date_creation");
$result = $query->fetchAll(PDO::FETCH_ASSOC);
print_r($result);
?>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>
</head>
<body>

  
</script>
<?php require $_SERVER['DOCUMENT_ROOT'].'/core/footer.php'; ?>




