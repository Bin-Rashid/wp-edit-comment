# wp-edit-comment
This implementation adds an inline comment editing feature to your WordPress theme, allowing users to edit comments directly on the page without being redirected to the admin dashboard.

Update your comment.php:

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
Ensure CSS for Modal in style.css:

css

Copy
#edit-comment-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    max-width: 600px;
    text-align: center;
}
#close-modal {
    float: right;
    cursor: pointer;
    font-size: 20px;
}

Handle AJAX Request in functions.php:
function update_comment_callback() {
    if (isset($_POST['comment_ID']) && isset($_POST['comment_content'])) {
        $comment_data = array(
            'comment_ID' => intval($_POST['comment_ID']),
            'comment_content' => sanitize_text_field($_POST['comment_content'])
        );
        wp_update_comment($comment_data);
        echo 'success';
    }
    wp_die();
}
add_action('wp_ajax_update_comment', 'update_comment_callback');
This should cover everything from rendering comments, adding the edit link and modal, to handling the AJAX request for updating comments. Check it out and let me know if it’s all set!
