$(() => {
  $(document).on('click', '#postComment', function() {
    const comment  = $('#commentField').val()
    const tweet_id = $('#commentField').data('tweet')

    if(comment != "") {
      $.post('http://localhost/twitter/core/ajax/comment.php', {
        comment: comment, 
        tweet_id: tweet_id
      }, (data) => {
        $('#comments').html(data)
        $('#commentField').val("")
      })
    }
  })
})