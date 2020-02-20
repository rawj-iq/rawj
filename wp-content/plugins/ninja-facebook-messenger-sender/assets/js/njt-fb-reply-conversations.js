var njt_fb_reply_conversations = function()
{
    var self = this;
    var $ = jQuery;

    self.send_to = '';
    self.page_id = '';
    self.page_token = '';
    self.content = '';

    self.all_conversations = [];
    self.results = [];
    self.total_sent = 0;
    self.total_fail = 0;

    self.init = function()
    {
        /*
         * Reply-Conversations btn clicked
         */
        $('#njt_fb_mess_reply_conversations_send_now').click(function(event) {
            var $this = $(this);
            var content = $('#njt_fb_mess_reply_conversations_content').val();
            self.send_to = $('#njt_fb_mess_reply_conversations_send_to').val();
            self.page_id = $this.data('fb_page_id');
            self.page_token = $this.data('fb_page_token');
            self.content = content;

            $this.addClass('updating-message');
            if (content != '') {
                $('#njt_fb_mess_reply_conversations_content').removeClass('njt_frm_error_not_empty');
                self.getConversations('', function(){
                    $this.removeClass('updating-message');
                });
                
            } else {
                $('#njt_fb_mess_reply_conversations_content').addClass('njt_frm_error_not_empty');
            }
        });
        /*
         * Reply Conversations again
         */
        $(document).on('click', '.njt_fb_mess_rc_send_again', function(event) {
            event.preventDefault();
            if (confirm(njt_fb_mess.are_you_sure)) {
                self.afterSend(true);
                $('.njt_fb_mess_reply_conversations_form_send').show();
                $('.njt_fb_mess_reply_conversations_form_results').hide();
                $('.njt_fb_mess_rc_send_again').hide();
            }
        });
    }
    self.getConversations = function(url, on_fail)
    {
        $.ajax({
            url: ajaxurl,
            type: 'POST',                
            data: {
                'action': 'njt_fb_mess_get_conversations',
                'send_to': self.send_to,
                'page_id': self.page_id,
                'page_token': self.page_token,
                'nonce': njt_fb_mess.nonce,
                'url': url
            },
        })
        .done(function(json) {
            if (json.success) {
                if (typeof json.data.conversations != 'undefined') {
                    $.each(json.data.conversations, function(k, v) {
                        self.all_conversations.push(v);
                    });                    
                }
                if (typeof json.data.url != 'undefined') {
                    self.getConversations(json.data.url, on_fail);
                } else {
                    //begin sending
                    //console.log(self.all_conversations);
                    self.beforeSend();
                    self.replyConversation(0);
                }
            } else {
                alert(json.data.mess);
                on_fail();
            }
        })
        .fail(function() {
            console.log("error while getting conversations.");
        });
    }

    self.replyConversation = function(index)
    {
        if (typeof self.all_conversations[index] != 'undefined') {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'njt_fb_mess_reply_conversation',
                    'page_token': self.page_token,
                    'mess': self.content,
                    'c_id': self.all_conversations[index]['id'],
                    'nonce': njt_fb_mess.nonce
                }
            })
            .done(function(json) {
                if (json.success) {
                    self.total_sent += 1;
                    self.results.push({'status' : 'success', 'name' : self.all_conversations[index]['sender'], 'mess' : json.data.mess})
                } else {
                    self.total_fail += 1;
                    self.results.push({'status' : 'error', 'name' : self.all_conversations[index]['sender'], 'mess' : json.data.mess})
                }
                self.updateResults();
                self.replyConversation(index + 1);
            })
            .fail(function() {
                //nonce error, maybe
                self.total_fail += 1;

                self.results.push({'status' : 'error', 'name' : self.all_conversations[index]['sender'], 'mess' : njt_fb_mess.unknown_error})

                self.updateResults();
                self.replyConversation(index + 1);
            });
            
        } else {
            //sending finish
            self.afterSend(false);
        }
    }
    self.updateResults = function()
    {
        $('.njt-fb-mess-rc-result-sent strong').text(self.total_sent);
        $('.njt-fb-mess-rc-result-fail strong').text(self.total_fail);

        var total_c = self.all_conversations.length;
        var percent = ((self.total_sent + self.total_fail) * 100) / total_c;
        percent = Math.ceil(percent);
        $('.njt-fb-mess-rc-meter').find('span').attr('style', 'width:' + percent + '%');
        $('.njt-fb-mess-rc-meter').find('strong').text(percent + '%');

        $('.njt-fb-mess-rc-fail-details').html('');
        $.each(self.results, function(i, e) {
            $('.njt-fb-mess-rc-fail-details').append('<li data-status="'+e.status+'">'+e.name+' : '+ e.mess +'</li>');
        });
    }
    self.beforeSend = function()
    {
        $('.njt_fb_mess_reply_conversations_form_send').hide();
        $('.njt_fb_mess_reply_conversations_form_results').show();
    }
    self.afterSend = function(reset_html)
    {
        self.resetVar();
        $('.njt_fb_mess_rc_send_again').show();
        $('#njt_fb_mess_reply_conversations_send_now').removeClass('updating-message');
        if (reset_html) {
            $('.njt-fb-mess-rc-result-sent strong').text('0');
            $('.njt-fb-mess-rc-result-fail strong').text('0');

            $('.njt-fb-mess-rc-meter').find('span').attr('style', 'width:0%');
            $('.njt-fb-mess-rc-meter').find('strong').text('0%');

            $('.njt-fb-mess-rc-fail-details').html('');
        }
    }
    self.resetVar = function()
    {
        self.all_conversations = [];
        self.results = [];
        self.total_sent = 0;
        self.total_fail = 0;
    }
}
jQuery(document).ready(function($) {
    var njt_fb_reply_conversations_app = new njt_fb_reply_conversations();
    njt_fb_reply_conversations_app.init();
});