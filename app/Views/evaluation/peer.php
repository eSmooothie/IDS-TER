<div class="container-fluid d-flex justify-content-center flex-row p-3">
  <div class="col-xl-3 col-lg-2"></div>
  <div class="col-sm bg-light bg-gradient rounded border mb-3 p-3">
    <div class="d-flex flex-row mb-3">
      <div class="col-2 border me-2">

      </div>
      <div class="col">
        <p class="mb-0 fs-5 fw-bold"><?php echo "{$evaluated['LN']}, {$evaluated['FN']}"; ?></p>
        <p class="">ID#<?php echo "{$evaluated['ID']}"; ?></p>
      </div>
    </div>
    <!-- direction -->
    <div class="" style="font-size:14px;">
      <p class="mb-0">DIRECTION:</p>
      <ul>
         <li>Please answer all questions carefully</li>
         <li>Check the appropriate number, which corresponds to your honest evaluation.</li>
      </ul>
      <table class="table border text-center">
        <thead class="">
          <tr>
            <th colspan="4" scope="col">Scale</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Never</td>
            <td>Seldom</td>
            <td>Often</td>
            <td>Always</td>
          </tr>
          <tr>
            <td>1</td>
            <td>2-3</td>
            <td>4-5</td>
            <td>6</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="">
      <form class="evaluation">
        <input type="hidden" name="evaluated_id" value="<?php echo "{$evaluated['ID']}"; ?>">
        <input type="hidden" name="evaluator_id" value="<?php echo "$evaluator_id"; ?>">
        <input type="hidden" name="eval_type" value="2">
        <?php
          $counter = 0;
          foreach ($questions as $key => $value) {
            $counter += 1;
            $qid = $value['ID'];
            $question = $value['QUESTION'];
            ?>
            <div class="border mb-3 d-flex p-2 rounded border-primary">
              <p class="fw-bold me-2">#<?php echo "$counter"; ?></p>
              <div class="w-100">
                <p class="text-wrap"><?php echo "$question"; ?></p>
                <div class="">
                  <table class="table">
                     <tr>
                       <td class="chc"></td>
                       <td class="chc">1</td>
                       <td class="chc">2</td>
                       <td class="chc">3</td>
                       <td class="chc">4</td>
                       <td class="chc">5</td>
                       <td class="chc">6</td>
                       <td class="chc"></td>
                     </tr>
                     <tr>
                       <td class="">Never</td>
                       <td class=""><input type="radio" name="rate[]" value="1" required></td>
                       <td class=""><input type="radio" name="rate[]" value="2" required></td>
                       <td class=""><input type="radio" name="rate[]" value="3" required></td>
                       <td class=""><input type="radio" name="rate[]" value="4" required></td>
                       <td class=""><input type="radio" name="rate[]" value="5" required></td>
                       <td class=""><input type="radio" name="rate[]" value="6" required></td>
                       <td class="">Always</td>
                     </tr>
                  </table>
                </div>
              </div>
            </div>
            <?php
          }
         ?>
         <div class="d-flex justify-content-center mb-3 mt-2">
           <button type="submit" class="btn btn-primary" name="button">Submit</button>
         </div>
      </form>
    </div>
  </div>
  <div class="col-xl-3 col-lg-2"></div>
</div>
<script src="<?php echo "$baseUrl/assets/js/evaluation.js"; ?>" charset="utf-8"></script>
