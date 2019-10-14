$(() => {
  $(document).on('click', '.deleteComment', function() {
    const commentID = $(this).data('comment');
    const tweet_id  = $(this).data('tweet');

    $.post('http://localhost/twitter/core/ajax/deleteComment.php', {deleteComment: commentID}, () => {
      $.post('http://localhost/twitter/core/ajax/popuptweet.php', {showpopup: tweet_id}, (data) => {
        $('.popupTweet').html(data)
        $('.tweet-show-popup-box-cut').click(function() {
          $('.tweet-show-popup-wrap').hide()
        })
      })
    })
  })
})