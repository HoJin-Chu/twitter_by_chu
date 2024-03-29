$(() => {
  $(document).on('click', '#messagePopup', function() {
    const getMessages = 1

    $.post('http://localhost/twitter/core/ajax/messages.php', {showMessage: getMessages}, (data) => {
      $('.popupTweet').html(data)
      $('#messages').hide()
    })
  })

  $(document).on('click', '.people-message', function() {
    const get_id = $(this).data('user')
    
    $.post('http://localhost/twitter/core/ajax/messages.php', {showChatPopup: get_id}, (data) => {
      $('.popupTweet').html(data)
      if(autoscroll)
        scrolldown()

      $('#chat').on('scroll', function() {
        if($(this).scrollTop() < this.scrollHeight - $(this).height())
          autoscroll = false
        else
          autoscroll = true
      })
      $('.close-msgPopup').click(function() {
        clearInterval(timer)
      })
    })

    getMessages = function() {
      $.post('http://localhost/twitter/core/ajax/messages.php', {showChatMessage: get_id}, (data) => {
        $('.main-msg-inner').html(data)
        if(autoscroll)
          scrolldown()

        $('#chat').on('scroll', function() {
          if($(this).scrollTop() < this.scrollHeight - $(this).height())
            autoscroll = false
          else
            autoscroll = true
        })
        $('.close-msgPopup').click(function() {
          clearInterval(timer)
        })
      })
    }

    const timer = setInterval(getMessages, 1000)
    getMessages()

    autoscroll = true
    scrolldown = function() {
      $('#chat').scrollTop($('#chat')[0].scrollHeight)
    }
    
    $(document).on('click', '.back-messages', function() {
      const getMessages = 1
  
      $.post('http://localhost/twitter/core/ajax/messages.php', {showMessage: getMessages}, (data) => {
        $('.popupTweet').html(data)
        clearInterval(timer)
      })
    })

    $(document).on('click', '.deleteMsg', function() {

      const messageID = $(this).data('message')
      $('.message-del-inner').height('100px')

      $(document).on('click', '.cancel', function() {
        $('.message-del-inner').height('0px')
      })

      $(document).on('click', '.delete', function() {
        $.post('http://localhost/twitter/core/ajax/messages.php', {deleteMsg: messageID}, (data) => {
          $('.message-del-inner').height('0px')
          getMessages()
        })
      })

    })

  })
})