$(() => {
  $(document).on('click', '.t-show-popup', function() {
    const tweet_id = $(this).data('tweet')
    $.post('http://localhost/twitter/core/ajax/popuptweet.php', {showpopup: tweet_id}, (data) => {
      $('.popupTweet').html(data)
      $('.tweet-show-popup-box-cut').click(function() {
        $('.tweet-show-popup-wrap').hide()
      })
    })
  })
})