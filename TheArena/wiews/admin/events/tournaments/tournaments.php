<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();
$query = $db->query('SELECT * FROM ' . PREFIX . 'tournaments');
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Tournois</h1>
<input type="text" id="myinput" class="form-control" placeholder="Insérez une valeur pour filtrer le tableau..." title="Insérez une valeur">

<table class="table table-hover table-bordered w-100">
    <thead>

        <th><span id="id" class="w3-button table-column">ID <i class="caret"></i></span></th>
        <th><span id="name" class="w3-button table-column">Nom <i class="caret"></i></span></th>
        <th><span id="description" class="w3-button table-column">Description <i class="caret"></i></span></th>
        <th><span id="price" class="w3-button table-column">Prix <i class="caret"></i></span></th>
        <th><span id="date" class="w3-button table-column">Date <i class="caret"></i></span></th>
        <th><span id="state" class="w3-button table-column">État <i class="caret"></i></span></th>
        <th><span id="event_type" class="w3-button table-column">Type d'événement <i class="caret"></i></span></th>
        <th><span id="event_id" class="w3-button table-column">Événement <i class="caret"></i></span></th>
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
            let row = table.insertRow(-1);
            let id = row.insertCell(0);
            id.innerHTML = data.id;

            let name = row.insertCell(1);
            name.innerHTML = data.name;

            let description = row.insertCell(2);
            description.innerHTML = data.description;

            let price = row.insertCell(3);
            price.innerHTML = data.price;
            let date = row.insertCell(4);

            date.innerHTML = data.date;
            let state = row.insertCell(5);
            state.innerHTML = data.state;
            let event_type = row.insertCell(6);
            event_type.innerHTML = data.event_type;
            let event_id = row.insertCell(7);
            event_id.innerHTML = data.event_id;
            let actions = row.insertCell(8);
            actions.innerHTML = `<a class="btn btn-primary m-1" href="admin_tournament_read?id=${data.id}">Voir</a> <a class="btn btn-primary m-1" href="admin_tournament_update?id=${data.id}">Modifier</a> <a class="btn btn-primary m-1" href="admin_tournament_delete?id=${data.id}">Supprimer</a>`;
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
<a href="admin_tournament_create" class="btn btn-primary m-1">Ajouter</a>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>