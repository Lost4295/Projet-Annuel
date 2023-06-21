</div>
</div>
</div>
</div>
<div class="row footer">
    <div class="col px-0">
        <footer class="footer pt-4 pb-2">
            <div class="d-flex justify-content-around align-items-center">
                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block logo">
                <a href="/cgu" class="m-4 p-3">Conditions générales d'utilisation</a>
                <a href="/cgv" class="m-4 p-3">Conditions générales de vente</a>
                <a href="/legal" class="m-4 p-3">Mentions légales</a>
                <a href="/contact" class="m-4 p-3">Nous contacter</a>
                <?php if (isConnected()) { ?>
                    <div>
                        <a class="btn btn-warning messages" href="/chat" id="messages">Messagerie</a>
                    </div>
                <?php  } ?>
            </div>
            <p class="text-center text-muted">
                &copy; <?php echo date("Y"); ?> - Ylan Turin--Kondi, Esteban Bonnard, Zacharie Roger
            </p>
        </footer>
    </div>
</div>
</body>

<script>
    window.onload = (event) => {
        setTimeout(function() {
            document.getElementById("loading").classList.add('hideev');
            setTimeout(function() {
                document.getElementById("loading").classList.add('d-none');
            }, 600)
        }, 900);
    }

    var theme = window.localStorage.getItem('data-bs-theme');
    const switchBox = document.querySelector(".sun-moon");
    if (theme) document.documentElement.setAttribute('data-bs-theme', theme);
    if (theme == 'dark') {
        switchBox.classList.remove("move");
    } else {
        switchBox.classList.add("move");
    }

    document.getElementById('changeToDarkMode').onclick = function() {
        if (window.localStorage.getItem('data-bs-theme') == 'dark') {
            document.documentElement.setAttribute('data-bs-theme', 'light');
            window.localStorage.setItem('data-bs-theme', 'light');
            switchBox.classList.add("move");
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            window.localStorage.setItem('data-bs-theme', 'dark');
            switchBox.classList.remove("move");
        }
    };
    <?php if (isConnected()) { ?>
        var btn = document.getElementById("messages");
        btn.onclick = function() {
            modal.style.display = "block";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    <?php } ?>

    function myFunction() {
        var dropdown = document.getElementById("thedropdown");
        dropdown.classList.toggle("show");

        window.onclick = function(event) {
            if (!event.target.matches('.dropper') && !event.target.matches('#avatar') && !event.target.matches('#triangle')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    }


    var as = document.getElementsByTagName('a');
    let link1 = document.getElementById('link1');
    let link2 = document.getElementById('link2');
    let link3 = document.getElementById('link3');
    for (var i = 0; i < as.length; i++) {
        as[i].addEventListener('click', function(e) {
            e.preventDefault();
            let tableau = {};
            var url = this.getAttribute('href');
            var title = this.innerHTML;
            link3.innerHTML = link2.innerHTML;
            link3.href = link2.href;
            link2.innerHTML = link1.innerHTML;
            
            
            link2.href = link1.href;
            link1.innerHTML = title;
            link1.href = url;
            let forms = new FormData();
            tableau.link3 = {title: link3.innerHTML, url: link3.href};
            tableau.link2 = {title: link2.innerHTML, url: link2.href};
            tableau.link1 = {title: title, url: url};
            
            
            forms.append("data", JSON.stringify(tableau));
            fetch('/core/savevalue.php',{
                method: 'POST',
                body: forms
                })
                .then(response => response.json())
                .then(data => {
                })

            // window.location.href = url;
        });
    }

    function disappear() {
        var x = document.getElementById("alert");
        x.style.opacity = "0";
        setTimeout(function() {
            x.style.display = "none";
        }, 600);
    }

    function timeoutmod() {
        var modal = document.getElementById("alert");
        setTimeout(function() {
            modal.style.display = "none";
        }, 10000);
    }
</script>


</html>