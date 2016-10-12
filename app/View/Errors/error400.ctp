<style type="text/css" media="screen">
  		.state-404 { background:url(/img/404.png) center 0 no-repeat; margin-top:60px;height:242px; font-size: 14px;padding: 196px 0 0 236px; }
</style>

<?php if ($name): ?>
  <div class="e404-main" alog-alias="e404-main-alog">
    <div class="e404-main-body">
      <div class="e404-body clearfix">        
        <div class="state-404 c9"><strong id="countDown">10</strong> 秒后返回 <a href="/">首页</a> 	 ...</div>
      </div>
    </div>
  </div>
  
	<script type="text/javascript">
		(function(){
			var countDown = document.getElementById("countDown");
			var t=10;
			for (var i = 0; i < t; i++) {
				setTimeout(function () {
                    countDown.innerHTML = --t;
                    if (t == 0) {
                        window.location.href = "/"; 
                    }
                }, 1000 * i);
			};
		})();
	</script>
  
<?php else: ?>
  <h2><?php echo $name; ?></h2>
  <p class="error">
  	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
  	<?php printf(
  		__d('cake', 'The requested address %s was not found on this server.'),
  		"<strong>'{$url}'</strong>"
  	); ?>
  </p>
  <?php
  if (Configure::read('debug') > 0):
  	echo $this->element('exception_stack_trace');
  endif;
  ?>  
<?php endif ?>

