$(() => {
  $('.search').keyup(function() {
    const search = $(this).val()
    $.post('http://localhost/twitter/core/ajax/search.php', {search: search}, data => {
      $('.search-result').html(data)
    })
  })
})