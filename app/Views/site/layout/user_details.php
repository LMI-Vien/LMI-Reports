    <div class="uiuserbox">
        <div class="dropdown">
          <button class="dropdown-toggle uiusertoggle" type="button" data-toggle="dropdown">
              <div class="uiuser">
                  <div class="uiuseravatarcontainer">
                      <img src="<?= base_url($home_details[0]->avatar);?>" class="uiavatar">
                  </div>
                  <div class="uiusername">
                      <div class="uiusername">
                        <div class="uiname"><?= $home_details[0]->user_greetings;?>, <span><?=$this->session->userdata['logged_in']['name']?></span></div>
                        <div class="uiday"><span><?=date('l, F d, Y')?></span></div>
                    </div>
                  </div>
                  <i class="fas fa-chevron-down"></i>
              </div>
          </button>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('login/logout');?>" id="logout" ><i class="fas fa-sign-out-alt"></i>Log out</a></li>
          </ul>
        </div>
    </div>
    <script type="text/javascript">
    var base_url = "<?= base_url();?>";      
    
    $(document).ready(function(){
        // 1800000 milliseconds = 30 minutes
       //  var idleState = false;
       //  var idleTimer = null;
       //  $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
       //      clearTimeout(idleTimer);
       //      idleState = false;
       //      idleTimer = setTimeout(function(){
       //          aJax.get(base_url + '/login/logout', function(){});
       //              $('#modal_logout').modal('show');
       //          idleState = true; 
       //      }, 3600000);
       //      //3600000  1 hour
       //  });
       // $("body").trigger("mousemove"); 
    });
    </script>