<?php if (!empty($errors)) { ?>
<div class="errors">
    <h3>Oops! Something went wrong.</h3>
    <ul>
        <?php foreach ($errors as $field => $error) { ?>
        <li class="error_msg_box" style="padding: 14px 0 5px 36px !important;"><?php echo $error; ?></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>