<!DOCTYPE html>
<html lang="en" class=" h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/b24469f289.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/bootstrap-5.0.2/css/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>/bootstrap-5.0.2/js/bootstrap.min.js" charset="utf-8"></script>
  <title>IDS | TER</title>
</head>
<body class="h-100" style="
background-color: #420516;
background: linear-gradient(90deg, #420516 0%, #B42B51 100%);
">
  <div class="d-flex flex-row h-100" style="">
    <div class="d-sm-block d-none col h-100"></div>

    <div class="col-3 d-flex align-items-center">
      <div class="p-3 shadow-lg w-100 rounded d-flex flex-column justify-content-start align-items-center" style="background-color: #e6577f;">
        <div class="col pt-5">
          <a href="<?php echo base_url(); ?>/admin"><img src="https://via.placeholder.com/150" alt="" class="d-block mx-auto rounded-circle"></a>
          <div class="text-center mt-3">
            <span class="d-block fs-3 text-white">INTEGRATED DEVELOPMENTAL SCHOOL</span>
            <span class="d-block fs-4 text-white mb-3">TEACHING EFFICIENCY RATING</span>
          </div>
        </div>
        <div class="col">
          <form id="userLogin">
            <!-- Log in as -->
            <div class="d-flex justify-content-around mb-3">
              <div class="">
                <input type="radio" class="btn-check" id="btn-check-student" name="logInAs" value="student" required>
                <label class="btn btn-primary" for="btn-check-student">I'm a student</label>
              </div>
              <div class="">
                <input type="radio" class="btn-check" id="btn-check-teacher" name="logInAs" value="teacher" required>
                <label class="btn btn-primary" for="btn-check-teacher">I'm a teacher</label>
              </div>
            </div>
            <!-- Username -->
            <div class="input-group flex-nowrap mb-4">
              <span class="input-group-text" id="label-username"><i class="fas fa-id-card-alt"></i></span>
              <input required type="text" name="username" class="form-control" placeholder="School ID Number" aria-label="Username" aria-describedby="label-username">
            </div>
            <!-- Password -->
            <div class="input-group flex-nowrap mb-2">
              <span class="input-group-text" id="label-password"><i class="fas fa-key"></i></span>
              <input required type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="label-password">
            </div>
            <!-- err message -->
            <div class="mb-2 text-center text-white">
              <span class="" id="errMsg"></span>
            </div>


            <div class="d-flex justify-content-center">
              <button type="submit" name="button" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="d-sm-block d-none col h-100"></div>
  </div>
  <div class="mb-5 mt-5" style="height:50px;">
  </div>
</body>
</html>
<script src="<?php echo base_url(); ?>/assets/js/login.js" charset="utf-8"></script>
