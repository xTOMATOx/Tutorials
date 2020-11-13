<?php
require 'core/init.php';

if(Input::exists())
{   if(Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check($_POST,array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'cpassword' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if($validation->passed())
        {
            echo 'passed';
        }
        else
        {
            foreach($validation->errors() as $err)
            {
                echo $err, "<br>";
            }
        }
    }       
}

?>
<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="field">
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" id="cpassword">
    </div>
    <div class="field">
        <label for="name">Name</label>
        <input type="name" name="name" value="<?php echo escape(Input::get('name'));?>" id="name">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">    
</form>