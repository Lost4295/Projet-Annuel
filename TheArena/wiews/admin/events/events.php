<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
$db = connectToDB();
$query = $db->prepare('SELECT * FROM ' . PREFIX . 'events');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Événements</h1>
<input type="text" id="myinput" class="form-control" placeholder="Insérez une valeur pour filtrer le tableau..." title="Insérez une valeur">
<table class="table table-hover table-bordered w-100">
    <thead>
        <th><span id="id" class="w3-button table-column">ID <i class="caret"></i></span></th>
        <th><span id="name" class="w3-button table-column">Nom<i class="caret"></i></span></th>
        <th><span id="manager_id" class="w3-button table-column">Pseudo de l'organisateur <i class="caret"></i></span></th>
        <th><span id="shop_id" class="w3-button table-column">ID du shop <i class="caret"></i></span></th>
        <th><span id="game" class="w3-button table-column">Jeu <i class="caret"></i></span></th>
        <th><span id="type" class="w3-button table-column">Type <i class="caret"></i></span></th>
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
            let form = new FormData();
            form.append('data', data.manager_id);
            form.append('action', 'formatUsers');
            fetch('/core/fetchformatter.php', {
                    method: 'POST',
                    body: form
                })
                .then(response => response.text())
                .then(result => {
                    let form2 = new FormData();
                    form2.append('data', data.type);
                    form2.append('action', 'formatTypeEvents');
                    fetch('/core/fetchformatter.php', {
                            method: 'POST',
                            body: form2
                        })
                        .then(response => response.text())
                        .then(typevent => {

                            let row = table.insertRow(-1);
                            let id = row.insertCell(0);
                            id.innerHTML = data.id;

                            let name = row.insertCell(1);
                            name.innerHTML = data.name;

                            let manager_id = row.insertCell(2);
                            manager_id.innerHTML = result;

                            let shop_id = row.insertCell(3);
                            shop_id.innerHTML = data.shop_id??'NULL';
                            let game = row.insertCell(4);
                            game.innerHTML = data.game;
                            let type = row.insertCell(5);
                            type.innerHTML = typevent;
                            let actions = row.insertCell(6);
                            actions.innerHTML = `<a class="btn btn-primary m-1" href="/admin/events/read?id=${data.id}">Voir</a> <a class="btn btn-primary m-1" href="/admin/events/update?id=${data.id}">Modifier</a> <a class="btn btn-primary m-1" href="/admin/events/delete?id=${data.id}">Supprimer</a>`;
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
<a class="btn btn-primary m-1" href="/admin/events/create">Ajouter</a>
<a class="btn btn-primary m-1" href="/admin/shops">Accéder à tous les shops</a>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php" ?>