$(() => {
  $(document).on('click', '.retweet', function() {
    $tweet_id = $(this).data('tweet');
    $user_id  = $(this).data('user');
    $counter       = $(this).find('.retweetsCount');
    $count         = $counter.text();
    $button        = $(this);

    $.post('http://localhost/twitter/core/ajax/retweet.php', {
      showPopup: $tweet_id, 
      user_id: $user_id
    }, (data) => {
      $('.popupTweet').html(data);
      $('.close-retweet-popup').click(() => {
        $('.retweet-popup').hide();
      });
    })
  })

  $(document).on('click', '.retweet-it', () => {
    const comment = $('.retweetMsg').val()
    $.post('http://localhost/twitter/core/ajax/retweet.php', {
      retweet: $tweet_id, 
      user_id: $user_id, 
      comment: comment
    }, () => {
      $('.retweet-popup').hide()
      $count++
      $counter.text($count)
      $button.removeClass('retweet').addClass('retweeted')
    })
  })
})