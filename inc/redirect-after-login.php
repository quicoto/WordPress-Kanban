<?php

function todo_login_redirect(){
  return home_url();
}

add_filter("login_redirect", "todo_login_redirect", 10, 3);