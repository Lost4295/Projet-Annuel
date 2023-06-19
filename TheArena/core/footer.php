</div>
</div>
</div>
</div>
<div class="row footer">
    <div class="col px-0">
        <footer class="footing pt-4 pb-2">
            <div class="d-flex justify-content-around align-items-center">
                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block logo">
                <a href="/cgu" class="m-4 p-3">Conditions générales d'utilisation</a>
                <a href="/cgv" class="m-4 p-3">Conditions générales de vente</a>
                <a href="/legal" class="m-4 p-3">Mentions légales</a>
                <a href="/contact" class="m-4 p-3">Nous contacter</a>
                <?php// if (isConnected()) { ?>
                    <div>
                        <button class="btn btn-warning messages" id="messages">Messagerie</button>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <iframe src="/core/chat" name="targetframe" allowTransparency="true" scrolling="no" frameborder="0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                <?php // } ?>
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
        }, 1000);
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
    //< ?php// if (isConnected()) { ?>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("messages");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    //< ?php //} ?>

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