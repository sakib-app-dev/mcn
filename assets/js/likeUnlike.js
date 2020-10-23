
$(document).ready(function () {
    //when user clicked on like button
    $(".like").click(function () {
        var post_id = $(this).attr('id');

        $.ajax({
            url: 'index.php',
            type: 'post',
            async: false,
            data: {
                'like': 1,
                'post_id': post_id
            },
            success: function () {

            }
        });
    });

    //when user clicked on unlike button
    $('.unlike').click(function () {
        var post_id = $(this).attr('id');
        $.ajax({
            url: 'index.php',
            type: 'post',
            async: false,
            data: {
                'unlike': 1,
                'post_id': post_id
            },
            success: function () {

            }
        });
    });
});

