<?php
// Get only the approved comments
$args = array(
    'status' => 'approve',
    'post_id' => get_the_ID(),
);

// The comment Query
$comments_query = new WP_Comment_Query();
$comments = $comments_query->query($args);
?>

<div class="comments">
    <?php
    // Comment Loop
    if ($comments) {
        foreach ($comments as $comment) { ?>
            <div id="comment-<?php comment_ID(); ?>" class="media comment">
                <?php echo get_avatar($comment, 64, null, null, array('class' => 'me-3')); ?>
                <div class="media-body">
                    <h5 class="mt-0">
                        <?php comment_author($comment); ?>
                        <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
                    </h5>
                    <div class="comment-content"><?php comment_text($comment); ?></div>
                </div>
            </div>
        <?php }
    } else {
        echo 'No comments found.';
    } ?>
    <div class="comment-form">
        <?php comment_form(); ?>
    </div>
</div>

<!-- Modal Structure -->
<div id="edit-comment-modal" style="display:none;">
    <div class="modal-content">
        <span id="close-modal">&times;</span>
        <form id="edit-comment-form">
            <textarea name="comment" id="edit-comment-field"></textarea>
            <input type="hidden" name="comment_ID" id="edit-comment-id">
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<script>
(function($) {
    $(document).ready(function() {
        console.log("Document ready");

        $('.edit-link a').on('click', function(event) {
            event.preventDefault();
            var commentElement = $(this).closest('.media.comment');
            if (commentElement.length === 0) {
                console.error("No parent with class 'media comment' found.");
                return;
            }
            var comment_id = commentElement.attr('id').replace('comment-', '');
            if (!comment_id) {
                console.error("Comment ID is undefined or empty.");
                return;
            }
            var comment_text = commentElement.find('.comment-content').text();
            console.log("Edit clicked: ", comment_id, comment_text);

            $('#edit-comment-id').val(comment_id);
            $('#edit-comment-field').val(comment_text);
            $('#edit-comment-modal').show();
        });

        $('#close-modal').on('click', function() {
            console.log("Close modal");
            $('#edit-comment-modal').hide();
        });

        $('#edit-comment-form').on('submit', function(event) {
            event.preventDefault();
            var data = {
                action: 'update_comment',
                comment_ID: $('#edit-comment-id').val(),
                comment_content: $('#edit-comment-field').val()
            };
            console.log("Form submitted: ", data);

            $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                console.log("AJAX response: ", response);
                $('#edit-comment-modal').hide();
                $('#comment-' + data.comment_ID + ' .comment-content').text(data.comment_content);
            });
        });
    });
})(jQuery);
</script>
