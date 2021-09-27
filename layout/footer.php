<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="social-icons">
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Behance</a></li>
          <li><a href="#">Linkedin</a></li>
          <li><a href="#">Dribbble</a></li>
        </ul>
      </div>
      <div class="col-lg-12">
        <div class="copyright-text">
          <p>Copyright 2020 Sprints Blog Co.</p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="<?= BASE_URL ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Additional Scripts -->
<script src="<?= BASE_URL ?>/assets/js/custom.js"></script>
<script src="<?= BASE_URL ?>/assets/js/owl.js"></script>
<script src="<?= BASE_URL ?>/assets/js/slick.js"></script>
<script src="<?= BASE_URL ?>/assets/js/isotope.js"></script>
<script src="<?= BASE_URL ?>/assets/js/accordions.js"></script>

<script language="text/Javascript">
  cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
  function clearField(t) { //declaring the array outside of the
    if (!cleared[t.id]) { // function makes it static and global
      cleared[t.id] = 1; // you could use true and false, but that's more typing
      t.value = ''; // with more chance of typos
      t.style.color = '#fff';
    }
  }
</script>
<script src="<?= BASE_URL ?>/assets/js/post.js"></script>
</body>

</html>