<!--MODAL POPUP-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-list-alt"></i> Change request type</h4>
      </div>

  <form action="#" method="post" role="form" enctype="multipart/form-data">
      <div class="modal-body">
        
          <div class="form-group">
            <label for="message-text" class="control-label">Choose from below:</label>
            <select  class='form-control' name='cmbReqType' required>
                <option value=''>--- Select here ---</option>
                <?php
                $query      = "SELECT * FROM `request_type`";
                $result     = mysql_query($query);
                while($row  = mysql_fetch_array($result))
                {
                    #POST VARIABLES
                    $request_type = $row['request'];

                    $div = "
                    <option value='".$request_type."'>".$request_type."</option>
                    ";
                    echo $div;
                    
                }
                #END WHILE
                ?>
            </select>
          </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="cmdUpdateReq">Update request type</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!--MODAL POPUP-->