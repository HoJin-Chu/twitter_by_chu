$(() => {
  const win = $(window) 
  let offset = 5

  win.scroll(function() {
    if($(document).height() <= (win.height() + win.scrollTop())) {
      offset += 5 
      $('#loader').show()
      $.post('http://localhost/twitter/core/ajax/fetchPosts.php', {fetchPosts: offset}, (data) => {
        $('.tweets').html(data)
        $('#loader').hide()
      })
    }
  })
})