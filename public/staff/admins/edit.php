<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
    redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $admin = [];
  $admin['id'] = $id;
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = update_admin($admin);
  if($result === true) {
    $id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The admin was created successfully.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {
    $admin = find_admin_by_id($id);
}

?>

<?php $page_title = 'Create Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

    <div class="admin new">
        <h1>Create Admin</h1>

        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/staff/admin/new.php'); ?>" method="post">
            <dl>
                <dt>First Name</dt>
                <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></dd>
            </dl>
            <dl>
                <dt>Username</dt>
                <dd><input type="text" name="username" value="<?php echo h($admin['username']); ?>" /></dd>
            </dl>
            <dl>
                <dt>Email</dt>
                <dd><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type="password" name="password" value="" /></dd>
            </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="confirm_password" value="" /></dd>
            </dl>
            <p>Passowrd should be atleast 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.</p>
            <div id="operations">
                <input type="submit" value="Create Admin" />
            </div>
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>