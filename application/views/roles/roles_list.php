<div id="content">
	<div class="box">
		<div class="header">
			<div class="text-right">
				<a class="button" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form')?>">Insert</a>
			</div>
		</div>
		<div class="content ">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>