<div class="panel panel-success">
    <div class="panel-heading">
    <!--<span class="pull-right"><a href="">Sign Up</a></span>-->
        <div class="pull-right">
            <!--<input type="text" class="form-control" name="txtSearch" placeholder="Search by Donation ID" autofocus />-->
        </div>
        <h4>What do you want to do?</h4>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTables-example">
                <tr>
                    <td>
                        <a href='admin-ticket-list.php'>
                            <i class="fa fa-angle-left"></i>&nbsp;&nbsp;Back to List
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class='warning'>
                        <a href='admin-ticket-staff.php?id=<?php echo $ticket_cd ?>'>
                            <i class="fa fa-user"></i>&nbsp;&nbsp;Assign Staff
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class='danger'>
                        <a href=''>
                            <i class="fa fa-remove"></i>&nbsp;&nbsp;Cancel Ticket
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /.row -->

