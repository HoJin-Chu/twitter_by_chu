$(() => {
  $('.search').keyup(function() {
    const search = $(this).val()
    $.post(
      'http://localhost/twitter/core/ajax/search.php', {
        search: search
      }, data => {
      $('.search-result').html(data)
    })
  })

  $(document).on('keyup', '.search-user', function() {
    $('.message-recent').hide()
    const search = $(this).val()
    $.post('http://localhost/twitter/core/ajax/searchUserInMsg.php', {
      search: search
    }, (data) => {
      $('.message-body').html(data)
    })
  })
})