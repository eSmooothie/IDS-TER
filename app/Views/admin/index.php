<body class=" h-100" style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
<div class="d-flex flex-row h-100" style="">
  <div class="d-sm-block d-none col  h-100"></div>

  <div class="col-3 h-100 d-flex align-items-center">
    <div class="p-3 shadow-lg w-100 rounded d-flex flex-column justify-content-start align-items-center" style="background-color: #e6577f;">
      <div class="col pt-5">
        <a href="<?php echo base_url(); ?>/"><img src="https://via.placeholder.com/150" alt="" class="d-block mx-auto rounded-circle"></a>
        <div class="text-center mt-3">
          <span class="d-block fs-3 text-white">INTEGRATED DEVELOPMENTAL SCHOOL</span>
          <span class="d-block fs-4 text-white mb-3">TEACHING EFFICIENCY RATING</span>
        </div>
      </div>
      <div class="col d-flex align-items-center">
        <form id="adminLogin" class="" action="" method="post">
          <!-- Username -->
          <div class="input-group flex-nowrap mb-4">
            <span class="input-group-text" id="label-username"><i class="fas fa-id-card-alt"></i></span>
            <input name="username" required type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="label-username">
          </div>
          <!-- Password -->
          <div class="input-group flex-nowrap mb-3">
            <span class="input-group-text" id="label-password"><i class="fas fa-key"></i></span>
            <input name="password" required type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="label-password">
          </div>
          <div id="errorMessage" class="d-none mb-3 text-center">
            <span class="text-white">Invalid username or password.</span>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" name="button" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="d-sm-block d-none col  h-100"></div>
</div>
<script src="<?php echo base_url(); ?>/assets/js/login.js" charset="utf-8"></script>
