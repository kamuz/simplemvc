<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<div class="row">
    <div class="col-md-12">
        <h1 class="pull-left">Posts</h1>
        <a href="<?php echo URLROOT ?>/posts/add" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add Post</a>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <?php foreach($data['posts'] as $post): ?>
        <div class="col-md-4">
            <div class="card card-body mb-3">
                <h4 class="card-title"><?php echo $post->title ?></h4>
                <div class="bg-light p-2 mb-3">Written by <?php echo $post->name ?> on <?php echo $post->create_at ?></div>
                <p class="card-text"><?php echo $post->body ?></p>
                <a href="<?php echo URLROOT ?>/posts/show/<?php echo $post->postId ?>" class="btn btn-dark">Read More</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>