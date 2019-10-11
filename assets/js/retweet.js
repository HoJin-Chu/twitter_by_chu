$(() => {
  $(document).on('click', '.retweet', function() {
    const tweet_id = $(this).data('tweet');
    const user_id  = $(this).data('user');
    $counter       = $(this).find('.retweetsCount');
    $count         = $counter.text();
    $button        = $(this);

    $.post('http://localhost/twitter/core/ajax/retweet.php', {
      showPopup: tweet_id, 
      user_id: user_id
    }, (data) => {
      $('.popupTweet').html(data);
      $('.close-retweet-popup').click(() => {
        $('.retweet-popup').hide();
      });
    })
  })
})