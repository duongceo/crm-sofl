<!-- URL hiện tại (dùng trong trường hợp redirect về trang web cũ) -->

<input type="hidden" value="" id="curr_url" />

<!-- Base URL -->

<input type="hidden" value="<?php echo base_url();?>" id="base_url" />

<!--Sub_folder-->
<input type="hidden" value="<?php  if(property_exists ($this, 'sub_folder')) echo $this->sub_folder;?>" id="input_sub_folder" />

<!-- Controller -->

<input type="hidden" value="<?php  if(property_exists ($this, 'controller')) echo $this->controller;?>" id="input_controller" />

<!-- Method -->

<input type="hidden" value="<?php   if(property_exists($this, 'method')) echo $this->method;?>" id="input_method" />

<!--User id-->

<input type="hidden" value="<?php echo $this->session->userdata('user_id');?>" id="input_user_id" />

<input type="hidden" value="<?php echo $this->session->userdata('role_id');?>" id="input_role_id" />

<!-- version cache -->

<input type="hidden" value="<?php echo _VER_CACHED_;?>" id="version-cache" />

<input type="hidden" value="<?php if(isset($_SESSION['pass_ipphone'])) echo $_SESSION['pass_ipphone'];?>" id="input_pass_ipphone" />
<input type="hidden" value="<?php if(isset($_SESSION['username_ipphone'])) echo $_SESSION['username_ipphone'];?>" id="input_username_ipphone" />


<?php if($this->controller == 'vip'){ ?>

<!-- URL thêm dòng -->

<input type="hidden" value="<?php echo base_url().$this->controller.'/show_add_item'?>" id="url_add_item" />

<!-- URL sửa dòng -->

<input type="hidden" value="<?php echo base_url().$this->controller.'/show_edit_item'?>" id="url_edit_item" />

<!-- URL xóa 1 dòng -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/delete_item' ?>" id="url_delete_item" />

<!-- URL xóa nhiều dòng -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/delete_multi_item' ?>" id="url_delete_multi_item" />


<!-- URL bật tắt 1 dòng -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/edit_active' ?>" id="url_edit_active" />

<!-- Add item fetch -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/AddItemFetch' ?>" id="url-add-item-fetch" />

<!-- Add item from fb -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/AddItemFromFb' ?>" id="url-add-item-from-fb" />

<!-- Add item from fb 2 -->

<input type="hidden" value="<?php echo base_url() . $this->controller . '/AddItemFromFb2' ?>" id="url-add-item-from-fb-2" />

<?php } ?>
