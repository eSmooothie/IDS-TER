<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p class="mb-1 fw-bold fs-5">Downloads</p>
      <div class="">
        <a href="<?php echo "$baseUrl/user/teacher/analytics/rating"; ?>" class="text-decoration-none">
          <i class="fas fa-star-half-alt"></i>
          Rating</a>
        <a href="<?php echo "$baseUrl/user/teacher/analytics/comment"; ?>" class="text-decoration-none ms-3">
          <i class="far fa-comments"></i>
          Comments</a>
        <a href="<?php echo "$baseUrl/user/teacher/analytics/download"; ?>" class="text-decoration-none ms-3">
          <i class="fas fa-download"></i>
          Download</a>
      </div>
    </div>
    <!-- tabular -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <table class="table table-striped table-hover border rounded">
        <thead class="text-center">
          <th scope="col">School Year</th>
          <th scope="col" class="col-1">Download Link</th>
        </thead>
        <tbody>
          <tr>
            <th scope="row">SY</th>
            <td><a href="#">Download</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mb-5">
    </div>
  </div>
</div>
