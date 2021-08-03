<!-- 
Author      : Kevin
Date        : 2015-05-08
Description : Adding new remarks to a ticket
 -->
<!--MODAL POPUP-->
<div class="modal fade" id="addTicketRemarks" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title text-info" ><span class="glyphicon glyphicon-comment"></span> Add New Ticket Remarks</h4>
      </div>

      <div class="modal-body">
        <div id="remark_form">
          <form action="#" method="post" role="form" class="form-horizontal" >
            
            <div class="form-group col-sm-12">
              <label class="control-label col-sm-2">Staff</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" id="remark_staff_name" readonly="readonly" value=""></input>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <label class="control-label col-sm-2">Date</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" id="remark_created_dt" readonly="readonly" value="<?php echo date('Y-m-d H:i:s') ?>"></input>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <label class="control-label col-sm-2">Remarks</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="remark_text" placeholder="Remarks" rows="8"></textarea>
              </div>
            </div>
          </form>
        </div>

        <div id="remark_loading" style="display:none;">
          <h4 class="text-info" align="center">Please wait, loading..</h4>
        </div>
        &nbsp;
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" id="remark_save">Add Remarks</a>
      </div>

    </div>
  </div>
</div>
<!--MODAL POPUP-->