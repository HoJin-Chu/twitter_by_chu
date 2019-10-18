$(() => {
  $(document).on('click', '#send', function() {
    const message = $('#msg').val()
    const get_id  = $(this).data('user')
    $.post('http://localhost/twitter/core/ajax/messages.php', {
      sendMessage: message,
      get_id: get_id
    }, (data) => {
      $getMessages()
      $('#msg').val('')
    })
  })
})