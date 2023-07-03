<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();
$query = $db->query('SELECT * FROM ' . PREFIX . 'forums');
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Forums</h1>
<input type="text" id="myinput" class="form-control" placeholder="Insérez une valeur pour filtrer le tableau..." title="Insérez une valeur">

<table class="table table-hover table-bordered">
    <thead>
        <th><span id="id" class="w3-button table-column">ID <i class="caret"></i></span></th>
        <th><span id="name" class="w3-button table-column">Nom <i class="caret"></i></span></th>
        <th><span id="description" class="w3-button table-column">Description <i class="caret"></i></span></th>
        <th><span id="date_creation" class="w3-button table-column">Date de création <i class="caret"></i></span></th>
        <th><span id="status" class="w3-button table-column">Statut <i class="caret"></i></span></th>
        <th><span id="author" class="w3-button table-column">Auteur <i class="caret"></i></span></th>
        <th>Actions</th>
    </thead>
    <tbody id="mytable">

    </tbody>
</table>




<script>
    var table = document.getElementById('mytable');
    var input = document.getElementById('myinput');
    var tableData = <?php echo json_encode($result); ?>;
    var caretUpClassName = 'bi bi-caret-up-fill';
    var caretDownClassName = 'bi bi-caret-down-fill';
    console.log(tableData)
    const sort_by = (field, reverse, primer) => {

        const key = primer ?
            function(x) {
                return primer(x[field]);
            } :
            function(x) {
                return x[field];
            };

        reverse = !reverse ? 1 : -1;

        return function(a, b) {
            return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
        };
    };

    function clearArrow() {
        let carets = document.getElementsByClassName('caret');
        for (let caret of carets) {
            caret.className = "caret";
        }
    }

    function toggleArrow(event) {
        let element = event.target;
        let caret, field, reverse;
        if (element.tagName === 'SPAN') {
            caret = element.getElementsByClassName('caret')[0];
            field = element.id
        } else {
            caret = element;
            field = element.parentElement.id
        }

        let iconClassName = caret.className;
        clearArrow();
        if (iconClassName.includes(caretUpClassName)) {
            caret.className = `caret ${caretDownClassName}`;
            reverse = false;
        } else {
            reverse = true;
            caret.className = `caret ${caretUpClassName}`;
        }

        tableData.sort(sort_by(field, reverse));
        populateTable();
    }

    function populateTable() {
        table.innerHTML = '';
        for (let data of tableData) {
            let form1 = new FormData();
            form1.append('data', data.author);
            form1.append('action', 'formatUsers');
            fetch('/core/fetchformatter.php', {
                    method: 'POST',
                    body: form1
                })
                .then(response => response.text())
                .then(auther => {
                    let form = new FormData();
                    form.append('data', data.status);
                    form.append('action', 'formatStatusForums');
                    fetch('/core/fetchformatter.php', {
                            method: 'POST',
                            body: form
                        })
                        .then(response => response.text())
                        .then(result => {
                            let row = table.insertRow(-1);
                            let id = row.insertCell(0);
                            id.innerHTML = data.id;
                            let name = row.insertCell(1);
                            name.innerHTML = data.name;
                            let description = row.insertCell(2);
                            description.innerHTML = data.description;
                            let date_creation = row.insertCell(3);
                            date_creation.innerHTML = data.date_creation;
                            let status = row.insertCell(4);
                            status.innerHTML = result;
                            let author = row.insertCell(5);
                            author.innerHTML = auther;
                            let actions = row.insertCell(6);
                            actions.innerHTML = `<a class="btn btn-primary m-1" href="/admin/forum/read?id=${data.id}">Voir</a> <a class="btn btn-primary m-1" href="/admin/forum/update?id=${data.id}">Modifier</a> <a class="btn btn-primary m-1" href="/admin/forum/delete?id=${data.id}">Supprimer</a>`;
                        });
                });
        }

        filterTable();
    }

    function filterTable() {
        let filter = input.value.toUpperCase();
        rows = table.getElementsByTagName("TR");
        let flag = false;

        for (let row of rows) {
            let cells = row.getElementsByTagName("TD");
            for (let cell of cells) {
                if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
                    flag = true;
                    break;
                }
            }

            if (flag) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

            flag = false;
        }
    }
    populateTable();

    let tableColumns = document.getElementsByClassName('table-column');

    for (let column of tableColumns) {
        column.addEventListener('click', function(event) {
            toggleArrow(event);
        });
    }


    input.addEventListener('keyup', function(event) {
        filterTable();
    });
</script>

<a href="/admin/forum/create" class="btn btn-primary m-1">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>