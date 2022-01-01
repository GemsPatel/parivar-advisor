<div class="modal fade forgot" id="hsquareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header show">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="exampleModalLabel"><?php echo getLangMsg("fyp")?></h3>
      </div>
      <div class="modal-body">
        <p><?php echo getLangMsg("fgmsg");?></p>
        <form method="post" id="forgot" onsubmit="$('#btn_f_password').click(); return false; ">
          <div class="form-group">
            <label for="email-id" class="control-label font-14"><?php  echo getLangMsg("ea")?></label>
            <input type="text" class="form-control" id="email-id" placeholder="Enter your email address" name="forgot_email">
            <span class="input-notification forgot" for="forgot_email" id="login-error"></span>
            <span class="input-notification forgot" for="forgot_not_match" id="login-error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <input type="submit" value="Submit" name="forgot_password" id="btn_f_password"> 
        <span id="forgot_loading_img" class="hide"><img src="<?php echo asset_url('images/preloader-white.gif') ?>" alt="loader" /></span>       
      </div>
    </div>
  </div>
</div>