<?php include 'db_connect.php' ?>
<?php 
$answers = $conn->query("SELECT distinct(poll_id) from answers where user_id ={$_SESSION['login_id']}");
$ans = array();
while($row=$answers->fetch_assoc()){
	$ans[$row['poll_id']] = 1;
}
?>
<div class="col-lg-12">
	<div class="d-flex w-100 justify-content-center align-items-center mb-2">
		<label for="" class="control-label">Find poll</label>
		<div class="input-group input-group-sm col-sm-5">
          <input type="text" class="form-control" id="filter" placeholder="Enter keyword...">
          <span class="input-group-append">
            <button type="button" class="btn btn-primary btn-flat" id="search">Search</button>
          </span>
        </div>
	</div>
	<div class=" w-100" id='ns' style="display: none"><center><b>No Result.</b></center></div>
	<div class="row">
		<?php 
		$poll = $conn->query("SELECT * FROM poll_set where '".date('Y-m-d')."' between date(start_date) and date(end_date) order by rand() ");
		while($row=$poll->fetch_assoc()):
		?>
		<div class="col-md-3 py-1 px-1 poll-item">
			<div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo ucwords($row['title']) ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" style="display: block;">
               <?php echo $row['description'] ?>
               <div class="row">
               	<hr class="border-primary">
               	<div class="d-flex justify-content-center w-100 text-center">
               		<?php if(!isset($ans[$row['id']])): ?>
               			<a href="index.php?page=answer_poll&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-pen-square"></i> Take poll</a>
               		<?php else: ?>
               			<p class="text-primary border-top border-primary">Done</p>
               		<?php endif; ?>
               	</div>
               </div>
              </div>
            </div>
		</div>
	<?php endwhile; ?>
	</div>
</div>
<script>
	function find_poll(){
		start_load()
		var filter = $('#filter').val()
			filter = filter.toLowerCase()
			console.log(filter)
		$('.poll-item').each(function(){
			var txt = $(this).text()
			if((txt.toLowerCase()).includes(filter) == true){
				$(this).toggle(true)
			}else{
				$(this).toggle(false)
			}
			if($('.poll-item:visible').length <= 0){
				$('#ns').show()
			}else{
				$('#ns').hide()
			}
		})
		end_load()
	}
	$('#search').click(function(){
		find_poll()
	})
	$('#filter').keypress(function(e){
		if(e.which == 13){
		find_poll()
		return false;
		}
	})
</script>