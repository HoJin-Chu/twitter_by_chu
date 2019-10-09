$(() => {
  const regex = /[#|@](\w+)$/ig;

  $(document).on('keyup', '.status', function() {
    const content = $.trim($(this).val());
    const text    = content.match(regex);
    const max     = 140;

    if(text != null) {
      const dataString = 'hashtag='+text;

      $.ajax({
        type: "POST",
        url: "http://localhost/twitter/core/ajax/getHashtag.php",
        data: dataString,
        cache: false,
        success: function(data) {
          $('.hash-box ul').html(data)
          $('.hash-box li').click(function() {
            const value = $.trim($(this).find('.getValue').text())
            const oldContent = $('.status').val()
            const newContent = oldContent.replace(regex, "")

            $('.status').val(newContent + value + ' ')
            $('.hash-box li').hide()
            $('.status').focus()

            $('#count').text(max - content.length)
          })
        }
      })

    } else {
      $('.hash-box li').hide()
    }
    $('#count').text(max - content.length)

    if(content.length === max) {
      $('#count').css('color', '#f00')
    } else {
      $('#count').css('color', '#000')
    }
  })
})