<div class="container-fluid py-1">
	<?php include 'receipt2.php' ?>
</div>
<div class="modal-footer row display py-1">
		<div class="col-lg-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
			<button class="btn float-right btn-success mr-2" type="button" id="ticket">Ticket</button>
		</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: block
	}
	.border-gradien-alert{
		border-image: linear-gradient(to right, red , yellow) !important;
	}
	.border-alert th, 
	.border-alert td {
	  animation: blink 200ms infinite alternate;
	}

	@keyframes blink {
	  from {
	    border-color: white;
	  }
	  to {
	    border-color: red;
		background: #ff00002b;
	  }
	}
</style>
<script>

	$('#ticket').click(function(){
		start_load()
		var nw = window.open('receipt2.php?id=<?php echo $_GET['id'] ?>',"_blank","width=900,height=600")
		setTimeout(function(){
			nw.print()
			setTimeout(function(){
				nw.close()
				end_load()
			},500)
		},500)
	});
</script>