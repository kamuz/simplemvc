<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
    <hr>
    <h1><?php echo $data['post']->title ?></h1>
    <div class="bg-light p-2 mb-3">
        Written by <?php echo $data['user']->name ?> on <?php echo $data['post']->created_at ?>
    </div>
    <div>
        <?php echo $data['post']->body ?>
    </div>
    <?php if($data['post']->user_id == $_SESSION['user_id']): ?>
        <hr>
        <a href="<?php echo URLROOT ?>/posts/edit/<?php echo $data['post']->id ?>" class="btn btn-dark"><i class="fa fa-pencil"></i> Edit Post</a>
        <form action="<?php echo URLROOT ?>/posts/delete/<?php echo $data['post']->id ?>" method="POST" class="pull-right">
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
        </form>
    <?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>