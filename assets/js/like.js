$(() => {
  $(document).on('click', '.like-btn', function() {
    const tweet_id = $(this).data('tweet')
    const user_id  = $(this).data('user')
    const counter  = $(this).find('.likesCounter')
    const button   = $(this)
    let count      = counter.text()

    $.post(
      'http://localhost/twitter/core/ajax/like.php', {
        like: tweet_id, 
        user_id: user_id
      }, () => {
      button.addClass('unlike-btn')
      button.removeClass('like_btn')
      count++
      counter.text(count)
      button.find('.fa-heart-o').addClass('fa-heart')
      button.find('.fa-heart').removeClass('fa-heart-o')
    })
  });
})