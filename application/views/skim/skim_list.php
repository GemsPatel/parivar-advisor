<style>
a.button{
    text-decoration: none;
    color: #FFFFFF;
    background-color: #68B3C8;
    opacity: 1;
    display: inline-block;
    padding: 5px 15px 5px 15px;
    border-radius: 10px 10px 10px 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-right: 15px;
}
</style>
<div id="content">
	<div class="box">
		<div class="header">
			<div class="text-right">
				<?php if(true || $this->per_add == 0):?>
					<a class="button" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form')?>">Insert</a>
				<?php endif;?>
			</div>
		</div>
		<div class="content">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>