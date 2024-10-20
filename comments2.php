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
    
    <div class="comment-count">
        <?php
        $errorfixer_comment_count = get_comments_number();
        global $s;
        $search_query = get_search_query();
        
        if (empty($s)) {
            if (1 == $errorfixer_comment_count) {
                _e("1 Comment", "errorfixer");
            } else {
                printf(esc_html__("%d Comments", "errorfixer"), $errorfixer_comment_count);
            }
        } else {
            if (1 == $errorfixer_comment_count) {
                printf(esc_html__('1 Comment matching "%s"', 'errorfixer'), esc_html($search_query));
            } else {
                printf(esc_html__('%d Comments matching "%s"', 'errorfixer'), $errorfixer_comment_count, esc_html($search_query));
            }
        }
        ?>
    </div>
    <ol class="comment-list">
    <?php
    if ($comments) {
        foreach ($comments as $comment) {
            ?>
            <li id="comment-<?php comment_ID(); ?>" class="media comment">
                <?php echo get_avatar($comment, 64, null, null, array('class' => 'me-3')); ?>
                <div class="media-body">
                    <h5 class="mt-0">
                        <?php comment_author($comment); ?>
                        <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
                    </h5>
                    <div class="comment-content"><?php comment_text($comment); ?></div>
                    <div class="reply">
                        <?php
                        comment_reply_link(array(
                            'reply_text' => __('Reply', 'errorfixer'),
                            'depth'      => 1,
                            'max_depth'  => get_option('thread_comments_depth')
                        ));
                        ?>
                    </div>
                    <?php
                    // Fetch child comments
                    $child_comments = get_comments(array('parent' => $comment->comment_ID));
                    if ($child_comments) {
                        ?>
                        <ul class="children">
                            <?php
                            foreach ($child_comments as $child_comment) {
                                ?>
                                <li id="comment-<?php echo $child_comment->comment_ID; ?>" class="media comment">
                                    <?php echo get_avatar($child_comment, 64, null, null, array('class' => 'me-3')); ?>
                                    <div class="media-body">
                                        <h5 class="mt-0">
                                            <?php comment_author($child_comment); ?>
                                            <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
                                        </h5>
                                        <div class="comment-content"><?php comment_text($child_comment); ?></div>
                                        <div class="reply">
                                            <?php
                                            comment_reply_link(array(
                                                'reply_text' => __('Reply', 'errorfixer'),
                                                'depth'      => 2,
                                                'max_depth'  => get_option('thread_comments_depth')
                                            ));
                                            ?>
                                        </div>
                                        <?php
                                        // Fetch nested child comments
                                        $nested_child_comments = get_comments(array('parent' => $child_comment->comment_ID));
                                        if ($nested_child_comments) {
                                            ?>
                                            <ul class="children">
                                                <?php
                                                foreach ($nested_child_comments as $nested_child_comment) {
                                                    ?>
                                                    <li id="comment-<?php echo $nested_child_comment->comment_ID; ?>" class="media comment">
                                                        <?php echo get_avatar($nested_child_comment, 64, null, null, array('class' => 'me-3')); ?>
                                                        <div class="media-body">
                                                            <h5 class="mt-0">
                                                                <?php comment_author($nested_child_comment); ?>
                                                                <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
                                                            </h5>
                                                            <div class="comment-content"><?php comment_text($nested_child_comment); ?></div>
                                                            <div class="reply">
                                                                <?php
                                                                comment_reply_link(array(
                                                                    'reply_text' => __('Reply', 'errorfixer'),
                                                                    'depth'      => 3,
                                                                    'max_depth'  => get_option('thread_comments_depth')
                                                                ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </li>
            <?php
        }
    } else {
        echo 'No comments found.';
    }
    ?>
</ol>

<div class="not_found_comment">
    <?php
    if (!comments_open()) {
        _e("Comments are Closed", "errorfixer");
    }
    ?>
</div>
    <!-- commment pagination -->
<div class="comments-pagination">
    <?php
    // Comment pagination
    the_comments_pagination(array(
        'screen_reader_text' => __( 'Comments AAA' ),
        'aria_label'         => __( 'Comments' ),
		'class'              => 'comments-pagination',
        'prev_text' => __('Previous Comment', 'errorfixer'),
        'next_text' => __('Next Comment', 'errorfixer'),
    ))
    ?>
</div>
    <div class="comment-form">
        <?php comment_form();?>
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
