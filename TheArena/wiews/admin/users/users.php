<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/header.php";

define("TD", "<td>");
define("ENDTD", "</td>");?>

<h1>Utilisateurs</h1>
<?php
	$db= connectToDB();
	$query = $db->query(" SELECT * FROM ". PREFIX ."users");
	$listOfUsers = $query->fetchAll(PDO::FETCH_ASSOC);
	?>

<input type="text" id="myinput" class="form-control" placeholder="Search..." title="Type in something">
<table class="table table-hover table-bordered w-100" aria-describedby="users-list">
    <thead>
		<th><span id="id" class="w3-button table-column">ID <i class="caret"></i></span></th>
		<th><span id="scope" class="w3-button table-column">Scope<i class="caret"></i></span></th>
		<th><span id="username" class="w3-button table-column">Pseudo<i class="caret"></i></span></th>
		<th><span id="email" class="w3-button table-column">Email <i class="caret"></i></span></th>
		<th><span id="visibility" class="w3-button table-column">Visibilité <i class="caret"></i></span></th>
		<th><span id="status" class="w3-button table-column">Status <i class="caret"></i></span></th>
		<th>Actions</th>
    </thead>
    <tbody id="mytable">
<?php
//    foreach ($listOfUsers as $user){
//					echo " <tr> ";
//					echo TD.$user["id"].ENDTD ;
//					echo TD.formatScope($user["scope"]).ENDTD ;
//					echo TD.$user["username"].ENDTD ;
//					echo TD.$user["email"].ENDTD ;
//					echo TD.formatVisibility($user["visibility"]).ENDTD ;
//					echo TD.formatStatusUsers($user["status"]).ENDTD ;
//					echo TD."<a href='/admin/users/read?id=". $user["id"]."' class='btn btn-primary'>Plus d'informations</a>".ENDTD;
//                    echo " </tr> ";
//				}
?>
    </tbody>
</table>

<th></th>
<tbody id="mytable">

<script>
    var table = document.getElementById('mytable');
    var input = document.getElementById('myinput');
    var tableData = <?php echo json_encode($listOfUsers); ?>;
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

            let scope = row.insertCell(1);
            scope.innerHTML = data.scope;

            let username = row.insertCell(2);
            username.innerHTML = data.username;

            let email = row.insertCell(3);
            email.innerHTML = data.email;
            let visibility = row.insertCell(4);
            visibility.innerHTML = data.visibility;
            let status = row.insertCell(5);
            status.innerHTML = data.status;
            let actions = row.insertCell(6);
            actions.innerHTML = `<a href='/admin/users/read?id=${data.id}' class='btn btn-primary m-1'>Plus d'informations</a>`;

		
		
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
<a href="/admin/users/create" class="btn-primary btn">Créer un utilisateur</a>
<?php require $_SERVER['DOCUMENT_ROOT']."/wiews/admin/footer.php" ?>
