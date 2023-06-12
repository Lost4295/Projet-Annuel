<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->

<?php require $_SERVER['DOCUMENT_ROOT'].'/core/header.php'; ?>
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

  <div>
    <h2>Product Table</h2>
    <p>Key in your input to filter the table:</p>

    <input type="text" id="myinput" placeholder="Search..." title="Type in something">

    <p>Click on the header of a column to sort the table:</p>

    <table>
      <thead><tr>
        <th><span id="name" class="w3-button table-column">Name <i class="caret"></i></span></th>
        <th><span id="quantity" class="w3-button table-column">Quantity <i class="caret"></i></span></th>
        <th><span id="price" class="w3-button table-column">Price <i class="caret"></span></i></th>
        <th><span id="expiry" class="w3-button table-column">Expiry Date <i class="caret"></i></span></th>
      </tr></thead>
      <tbody id="mytable"></tbody>
    </table>
  </div>
<script>
    var table = document.getElementById('mytable');
var input = document.getElementById('myinput');
var tableData = [
{name: 'Onion', quantity: 29, price: 1.2, expiry: '2021-09-12'}, {name: 'Apple', quantity: 55, price: 3.3, expiry: '2021-09-22'}, {name: 'Potato', quantity: 25, price: 2.5, expiry: '2021-09-18'}, {name: 'Carrot', quantity: 8, price: 0.8, expiry: '2021-09-25'}
];
var caretUpClassName = 'bi bi-caret-up-fill';
var caretDownClassName = 'bi bi-caret-down-fill';
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
  }
  else {
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
    let name = row.insertCell(0);
    name.innerHTML = data.name;

    let quantity = row.insertCell(1);
    quantity.innerHTML = data.quantity;

    let price = row.insertCell(2);
    price.innerHTML = data.price;

    let expiry = row.insertCell(3);
    expiry.innerHTML = data.expiry;
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
<?php require $_SERVER['DOCUMENT_ROOT'].'/core/footer.php'; ?>




