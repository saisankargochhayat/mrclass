<script src="<?php echo HTTP_ROOT; ?>js/accordian.js"></script>   
<div class="cmn_static_mc carer_mcl">
	<div class="wrapper">
		<h1>Careers</h1>
		<div class="static_pg_cnt">
			<h2>Why Work in MrClass?</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
			<h2 class="hir_crr">MrClass is hiring for <span>Bhubaneswar</span>, India Location for the following positions!</h2>
			<div class="accd_carr">			
				<div class="panel-group" id="accordion">
				  <div class="panel panel-default car_acd_cnt fl">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
						  What is MrClass?
						</a><i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
					  </h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in">
					  <div class="panel-body">
						www.MrClass.in is 'about your child, around your home'. We help unearth the best your city has to offer kids in and around your neighborhood - from kids events to fun family outings, discounts and offers, to a comprehensive listings of products and services for your children. MrClass is the fun and easy way to find, share, review and talk about what's great - and not so great - for your kids in the city.
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default car_acd_cnt fr">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
						  Is MrClass free?
						</a><i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
					  </h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse">
					  <div class="panel-body">
						 Yes! Other than sponsored listings and advertising, you can use the site for free.
					  </div>
					</div>
				  </div>
				   <div class="cb"></div>
				  <div class="panel panel-default car_acd_cnt fl">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
						  Where can we use it?
						</a><i class="indicator glyphicon glyphicon-chevron-up pull-right"></i>
					  </h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse">
					  <div class="panel-body">
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default car_acd_cnt fr">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
						  Is MrClass free?
						</a><i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
					  </h4>
					</div>
					<div id="collapsefour" class="panel-collapse collapse">
					  <div class="panel-body">
						 Yes! Other than sponsored listings and advertising, you can use the site for free.
					  </div>
					</div>
				  </div>
				  <div class="cb"></div>
				</div>
			</div>
			<div class="post_resu">
				<h2>Post Your Resume!</h2>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
				<div class="upload-div-sub">
					<span class="fl"><img src="<?php echo HTTP_ROOT; ?>images/form/attach_btn.png"></span>
					<span class="up-text fl">Attach File</span>
					<input type="file" class="attach-img-sub" id="">
					<div class="cb"></div>
				</div>
				<button type="submit" class="cmn_btn_n pad_big">SUBMIT</button>		
			</div>
		</div>
	</div>
</div>
<script>
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);
</script>