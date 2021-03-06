<div class="list-group" style="height: 362px;">
	<?php echo $partners['ul'];?>
</div>
<button class="btn btn-primary"  onclick="expandPartListing();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">View Full Listing</button>

<div class="modal fade" tabindex="-1" role="dialog" id="expPartList">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Partner Listing</h4>
      </div>
      <div class="modal-body">
        <table id="partnerList" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
        			<th>Partner Name</th>
        			<?php
                if(isset($countys['requests'])){
                  echo "<th># of Requests</th>";
                }else{
                  echo "<th>% Positivity</th>";
                  echo "<th>Positives</th>";
                }
              ?>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$partners['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#partnerList').DataTable({
			responsive: true
		});

		// $("table").tablecloth({
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});
	function expandPartListing()
	{
		$('#expPartList').modal('show');
	}
</script>