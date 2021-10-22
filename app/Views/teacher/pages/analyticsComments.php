<div class="container-fluid d-flex flex-row">
  <div class="col-xl-2 col-lg-3 col-md-4"></div>
  <!-- working area -->
  <div class="col pt-2">
    <!-- working area -->
    <div class="bg-light bg-gradient rounded border mb-3 p-3">
      <p class="mb-1 fw-bold fs-5">Comments</p>
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
      <p></p>
      <div class="mb-2">
        <select id="select_sy" class="form-select">
          <option value="">LATEST SY</option>
        </select>
      </div>
    </div>
    <div class="bg-light bg-gradient rounded border mb-3 p-3" id="commentContainer">
      <div class="border text-wrap p-2 rounded mb-3">
        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse fermentum imperdiet iaculis. Ut tincidunt fringilla erat, a rhoncus ligula sagittis a. Pellentesque lacinia luctus enim eu porttitor. Aliquam sagittis erat urna. Curabitur eget dignissim quam. Nunc a libero ac eros dictum dictum. Nulla facilisi. Pellentesque convallis ut nibh id mollis. Integer et bibendum sem, et accumsan justo.</span>
        <div class="d-flex justify-content-end">
          <span style="font-size:10px;">ID:HASH</span>
        </div>
      </div>
      <div class="border text-wrap p-2 rounded mb-3">
        <span>Suspendisse commodo lacus eu magna ullamcorper, non sagittis nibh lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec laoreet dui et pellentesque ultricies. Nam nunc magna, bibendum quis suscipit ac, ultricies lacinia felis. Ut ultricies magna ipsum, sollicitudin faucibus augue tempor at. Aliquam erat volutpat. Ut magna purus, eleifend nec turpis ut, cursus rutrum urna. Nam sit amet auctor sem, vel vehicula arcu. Curabitur dui nibh, tincidunt eget ornare in, tincidunt et ipsum. Sed condimentum, nibh ut gravida blandit, urna diam placerat turpis, at fringilla nunc velit a lectus.</span>
        <div class="d-flex justify-content-end">
          <span style="font-size:10px;">ID:HASH</span>
        </div>
      </div>
    </div>
    <div class="mb-5">
    </div>
  </div>
</div>
