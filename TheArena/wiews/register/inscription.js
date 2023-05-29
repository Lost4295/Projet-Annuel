function verifyValues1() {
    let type = document.querySelector('input[name="type"]:checked').value;
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('pwd').value;
    let confirmPassword = document.getElementById('confirmpwd').value;
    if (type == "" || username == "" || email == "" || password == "" || confirmPassword == "") {
        alert("Veuillez remplir tous les champs.");
        return false;
    }

    return {
        type,
        username,
        email,
        password,
        confirmPassword

    }
}


function fetchType() {
    return fetch('/core/gettype.php', {
        method: 'GET'
    })
        .then(response => response.json())
        .catch((error) => {
            console.error('Error:', error);
        });
}

async function table1() {
    let type = await fetchType();
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('pwd').value;
    return {
        "Type": type,
        "Nom d'utilisateur": username,
        "E-mail": email,
    };
}

function table2() {
    let firstname = document.getElementById('firstname').value;
    let lastname = document.getElementById('lastname').value;
    let birthdate = document.getElementById('birthdate').value;
    let phonenumber = document.getElementById('phonenumber').value;
    let address = document.getElementById('address').value;
    let cp = document.getElementById('cp').value;
    let city = document.getElementById('city').value;
    let country = document.getElementById('country').value;
    return {
        "Prénom": firstname,
        "Nom": lastname,
        "Date d'anniversaire": birthdate,
        "Numéro de téléphone": phonenumber,
        "Adresse": address,
        "Code postal": cp,
        "Ville": city,
        "Pays": country
    }
}

function verifyValues2() {
    let firstname = document.getElementById('firstname').value;
    let lastname = document.getElementById('lastname').value;
    let birthdate = document.getElementById('birthdate').value;
    let phonenumber = document.getElementById('phonenumber').value;
    let address = document.getElementById('address').value;
    let cp = document.getElementById('cp').value;
    let city = document.getElementById('city').value;
    let country = document.getElementById('country').value;
    if (firstname == "" || lastname == "" || birthdate == "" || phonenumber == "" || address == "" || cp == "" || city == "" || country == "") {
        alert("Veuillez remplir tous les champs.");
        return false;
    }
    return {
        firstname,
        lastname,
        birthdate,
        phonenumber,
        address,
        cp,
        city,
        country
    }
}



//TODO : Requête ajax + passage à la page suivante si tout est ok
let btn = document.getElementById('continue');
let form1 = document.getElementById("form1");
let form2 = document.getElementById("form2");
let form3 = document.getElementById("form3");
let check1 = document.getElementById("check1");
let check2 = document.getElementById("check2");
let check3 = document.getElementById("check3");
let span = document.getElementById("errors");
span.setAttribute("hidden", "");
form2.setAttribute("hidden", "");
form3.setAttribute("hidden", "");

btn.addEventListener('click', clickHandler);

function clickHandler(event) {
    if (form1.getAttribute("hidden") == undefined && form2.getAttribute("hidden") == "") {
        let form1values = verifyValues1();
        if (form1values) {
            fetch('/core/verify1.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(form1values)
            }).then(response => response.json())
                .then(data => {
                    if (data.length == 0) {
                        span.innerHTML = "";
                        span.setAttribute("hidden", "");
                        form1.setAttribute("hidden", "");
                        form2.removeAttribute("hidden");
                        form3.setAttribute("hidden", "");
                        check1.setAttribute("class", "bi bi-check-circle-fill text-info");
                        return;
                    } else {
                        span.removeAttribute("hidden");
                        span.innerHTML = " Il y a des erreurs. Merci de corriger les champs suivants :<ul>";
                        let errortype = data.errortype
                        let errorusername = data.errorusername
                        let erroremail = data.erroremail
                        let errorpwd = data.errorpwd
                        let errorpwdconfirm = data.errorpwdconfirm
                        if (errortype) {
                            span.innerHTML += "<li> Type : " + errortype + "</li>";
                        }
                        if (errorusername) {
                            span.innerHTML += "<li> Nom d'utilisateur : " + errorusername + "</li>";
                        }
                        if (erroremail) {
                            span.innerHTML += "<li> Email : " + erroremail + "</li>";
                        }
                        if (errorpwd) {
                            span.innerHTML += "<li> Mot de passe : " + errorpwd + "</li>";
                        }
                        if (errorpwdconfirm) {
                            span.innerHTML += "<li> Confirmation du mot de passe : " + errorpwdconfirm + "</li>";
                        }
                        span.innerHTML += "</ul> ";
                        return;
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        } else {
            return;
        }
    }

    if (form2.getAttribute("hidden") == undefined && form3.getAttribute("hidden") == "") {

        let form2values = verifyValues2();
        if (form2values) {
            fetch('/core/verify2.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(form2values)
            }).then(response => response.json())
                .then(data => {
                    if (data.length == 0) {
                        span.innerHTML = "";
                        span.setAttribute("hidden", "");
                        form1.setAttribute("hidden", "");
                        form2.setAttribute("hidden", "");
                        form3.removeAttribute("hidden");
                        check2.setAttribute("class", "bi bi-check-circle-fill text-info");
                        btn.innerHTML = "M'inscrire";
                        const finalinfos = document.getElementById('finalinfos');

                        let firsttable = table1().then(data => {
                            return data;
                        });
                        let secondtable = table2()
                        firsttable.then(data => {
                            for (const key in data) {
                                const h3 = document.createElement('h3');
                                const div = document.createElement('div');
                                h3.textContent = key;
                                div.textContent = data[key];
                                finalinfos.appendChild(h3);
                                finalinfos.appendChild(div);
                            }
                        });
                        for (const key in secondtable) {
                            const h3 = document.createElement('h3');
                            const div = document.createElement('div');
                            h3.textContent = key;
                            div.textContent = secondtable[key];
                            finalinfos.appendChild(h3);
                            finalinfos.appendChild(div);
                        }
                        return;
                    } else {
                        span.removeAttribute("hidden");
                        span.innerHTML = " Il y a des erreurs. Merci de corriger les champs suivants :<ul>";
                        let errorfirstname = data.errorfirstname
                        let errorlastname = data.errorlastname
                        let errorbirthdate = data.errorbirthdate
                        let errorphonenumber = data.errorphonenumber
                        let erroraddress = data.erroraddress
                        let errorcp = data.errorcp
                        let errorcity = data.errorcity
                        let errorcountry = data.errorcountry
                        if (errorfirstname) {
                            span.innerHTML += "<li> Prénom : " + errorfirstname + "</li>";
                        }
                        if (errorlastname) {
                            span.innerHTML += "<li> Nom : " + errorlastname + "</li>";
                        }
                        if (errorbirthdate) {
                            span.innerHTML += "<li> Date de naissance : " + errorbirthdate + "</li>";
                        }
                        if (errorphonenumber) {
                            span.innerHTML += "<li> Numéro de téléphone : " + errorphonenumber + "</li>";
                        }
                        if (erroraddress) {
                            span.innerHTML += "<li> Adresse : " + erroraddress + "</li>";
                        }
                        if (errorcp) {
                            span.innerHTML += "<li> Code postal : " + errorcp + "</li>";
                        }
                        if (errorcity) {
                            span.innerHTML += "<li> Ville : " + errorcity + "</li>";
                        }
                        if (errorcountry) {
                            span.innerHTML += "<li> Pays : " + errorcountry + "</li>";
                        }
                        span.innerHTML += "</ul> ";
                        return;
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        } else {
            return;
        }
    }
    if (form1.getAttribute("hidden") == "" && form2.getAttribute("hidden") == "" && form3.getAttribute("hidden") == undefined) {
        checkCaptcha();
    }
}


const draggableElements = document.querySelectorAll('.draggable');
const dropZoneElements = document.querySelectorAll('.drop-zone');
const resetZone = document.getElementById('resetZone');



draggableElements.forEach((draggable) => {
    draggable.addEventListener('dragstart', dragStart);
});


dropZoneElements.forEach((dropZone) => {
    dropZone.addEventListener('dragover', dragOver);
    dropZone.addEventListener('drop', drop);
});


resetZone.addEventListener('drop', resetDraggableElements);



function dragStart(event) {
    const draggedElement = event.target;


    draggedElement.classList.add('dragging');


    event.dataTransfer.setData('text/plain', draggedElement.id);
}


function dragOver(event) {
    event.preventDefault();


    if (event.target.classList.contains('draggable')) {
        event.dataTransfer.dropEffect = 'none';
    } else {
        event.dataTransfer.dropEffect = 'move';
    }
}

function drop(event) {
    event.preventDefault();

    const existingDraggable = event.target.querySelector('.draggable');
    if (existingDraggable) {
        return;
    }

    const droppedElementId = event.dataTransfer.getData('text/plain');
    const droppedElement = document.getElementById(droppedElementId);

    event.target.appendChild(droppedElement);
    checkAllDropZonesFilled();
    draggableElements.forEach(function (image) {
        if (resetZone.contains(image)) {
            image.classList.add('with-margin');
        } else {
            image.classList.remove('with-margin');
        }
    });
}

function resetDraggableElements(event) {
    event.preventDefault();


    const droppedElementId = event.dataTransfer.getData('text/plain');
    const droppedElement = document.getElementById(droppedElementId);
    event.target.appendChild(droppedElement);
        if (resetZone.contains(droppedElement)) {
            droppedElement.classList.add('with-margin');
        } else {
            droppedElement.classList.remove('with-margin');
        }
    };


function checkAllDropZonesFilled() {
    var dropZones = document.getElementsByClassName("drop-zone");
    for (var i = 0; i < dropZones.length; i++) {
        var dropZone = dropZones[i];
        if (!dropZone.innerHTML.trim()) {
            return false;
        }
    }
    return getDataValuesInDropZone();
}

function getDataValuesInDropZone() {
    const dropZones = document.querySelectorAll('.drop-zone');
    const dataValues = [];

    dropZones.forEach(dropZone => {
        if (dropZone.parentNode.classList.contains('row')) {
            const img = dropZone.querySelector('img');
            const dataValue = img.dataset.value;
            dataValues.push(dataValue);
        }
    });
    return dataValues;
}

function checkCaptcha() {
    if (document.getElementById('cgu').checked) {
        var dataValues = checkAllDropZonesFilled();
        if (dataValues) {
            var xhr = new XMLHttpRequest();
            xhr.onload = function () {
                if (this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success == true) {
                        document.getElementById('allform').submit();
                    } else {
                        alert('Captcha invalide. Merci de réessayer.');
                    }
                }
            }
            xhr.open('POST', '/checkCaptcha', true);
            var data = new FormData();
            data.append('dataValues', JSON.stringify(dataValues));
            xhr.send(data);
        } else {
            alert('Veuillez remplir tous les champs');
        }
    }
    else {
        alert('Veuillez accepter les CGU');
    }
}
