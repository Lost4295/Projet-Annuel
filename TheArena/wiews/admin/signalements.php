<?php require 'header.php';

    $db = connectToDB();
    $queryPrepared = $db->query("SELECT * FROM " . PREFIX . "user_reports");
    $reports = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    $queryPrepared = $db->query("SELECT * FROM " . PREFIX . "users");
    $users = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Signalements</h1>

<input type="text" id="myinput" class="form-control" placeholder="Search..." title="Type in something">
<table class="table table-hover table-bordered w-100" aria-describedby="reports-table">
    <thead>
        <th><span id="id" class="w3-button table-column">ID <i class="caret"></i></span></th>
        <th><span id="user_id" class="w3-button table-column">Signaleur<i class="caret"></i></span></th>
        <th><span id="content" class="w3-button table-column">Contenu<i class="caret"></i></span></th>
        <th><span id="reported_id" class="w3-button table-column">ID de l'objet signalé <i class="caret"></i></span></th>
        <th><span id="discr" class="w3-button table-column">Type de signalament <i class="caret"></i></span></th>
        <th>Actions</th>
    </thead>
    <tbody id="mytable">
    </tbody>
</table>

<th></th>
<tbody id="mytable">

    <script>
        var table = document.getElementById('mytable');
        var input = document.getElementById('myinput');
        var tableData = <?php echo json_encode($reports); ?>;
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
                form.append('data', data.user_id);
                form.append('action', 'formatUsers');
                fetch('/core/fetchformatter.php', {
                        method: 'POST',
                        body: form
                    })
                    .then(response => response.text())
                    .then(peros => {
                        let form = new FormData();
                        form.append('data', data.discr);
                        form.append('action', 'formatTypeSignalement');
                        fetch('/core/fetchformatter.php', {
                                method: 'POST',
                                body: form
                            })
                            .then(response => response.text())
                            .then(signal => {
                                        let row = table.insertRow(-1);
                                        let id = row.insertCell(0);
                                        id.innerHTML = data.id;

                                        let user_id = row.insertCell(1);
                                        user_id.innerHTML = peros??'INCONNU';

                                        let content = row.insertCell(2);
                                        content.innerHTML = "\""+data.content+"\"";

                                        let reported_id = row.insertCell(3);
                                        reported_id.innerHTML =  data.reported_id ;
                                        let discr = row.insertCell(4);
                                        discr.innerHTML = signal;
                                        let actions = row.insertCell(5);
                                        actions.innerHTML = `<a href='/admin_signalement?id=${data.id}' class='btn btn-primary m-1'>Plus d'informations</a>`;
                                    });
                            });;
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
<?php include 'footer.php'?>
