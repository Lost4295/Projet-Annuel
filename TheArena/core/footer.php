</div>
</div>
</div>
<div class="row">
    <div class="col px-0">
        <footer class="footer bar py-4">
            <div class="d-flex justify-content-between align-items-center">
                <img src="../../img/logothearena-removebg.png" alt="Logo"  class="d-inline-block align-text-center logo">
                <div class="d-flex justify-content-between">
                    <a href="/cgu" class="m-5 p-3">Conditions générales d'utilisation</a>
                    <a href="/cgv" class="m-5 p-3">Conditions générales de vente</a>
                    <a href="/legal" class="m-5 p-3">Mentions légales</a>
                    <a href="/contact" class="m-5 p-3">Nous contacter</a>
                </div>
                <div>
                    <button class="btn btn-warning messages" id="messages">Messagerie</button>
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p>Some text in the Modal..</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted">
                &copy; <?php echo date("Y");?> - Ylan Turin--Kondi, Esteban Bonnard, Zacharie Roger
            </p>
        </footer>
    </div>
</div>
<script>
    // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("messages");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</div>
</body>
</html>
