<div class="cmn_static_mc mc_<?php echo $pagedata['StaticPage']['code']; ?>">
	<div class="wrapper">
		<h1><?php echo $pagedata['StaticPage']['title']; ?></h1>
        <div class="static_pg_cnt"><?php echo $this->element('StaticPage/' . $pagedata['StaticPage']['code']); ?></div>
	</div>
</div>
