<!-- content -->
<div class="col ps-3">
<!-- content -->
  <div class="bg-light bg-gradient border rounded p-3 mb-3">
    <p class="fw-bold fs-4">Subjects</p>
  </div>
  <div class="bg-light bg-gradient border rounded p-3 mb-3">
    <div class="d-flex">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
        <i class="fas fa-plus"></i>Add</button>
    </div>
  </div>
  <div class="bg-light bg-gradient border rounded p-3 mb-3">
    <div class="d-flex">
      <input type="text" name="" class="form-control" id="searchSubject" placeholder="Search">
    </div>
    <div class="">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="col-1">ID</th>
            <th scope="col">Description</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="subjectTbody">
          <?php
            foreach ($subjects as $key => $value) {
              $id = $value['ID'];
              $name = $value['DESCRIPTION'];
              ?>
              <tr>
                <th scope="row"><?php echo "$id"; ?></th>
                <td><?php echo "$name"; ?></td>
                <td></td>
              </tr>
              <?php
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="" id="addNewSubject">
        <div class="modal-body">
          <!-- Do Something -->
          <div class="mb-3">
            <label for="subjectName">Subject Name</label>
            <input required type="text" class="form-control" name="subjectName" id="subjectName">
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo "$baseUrl/assets/js/adminSubject.js"; ?>" charset="utf-8"></script>
