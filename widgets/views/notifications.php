<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\services\Assets;

$this->registerjsVar('mail_loadMessageUrl', Url::to(['/mail/mail/show', 'id' => '-messageId-']));
$this->registerjsVar('mail_viewMessageUrl', Url::to(['/mail/mail/index', 'id' => '-messageId-']));

Assets::register($this);
?>
<div class="btn-group">
    <a href="#" id="icon-messages" class="dropdown-toggle" data-toggle="dropdown"><i
            class="fa fa-play"></i></a>
    <span id="badge-messages" style="display:none;"
          class="label label-danger label-notification">1</span>
    <ul id="dropdown-messages" class="dropdown-menu">
    </ul>
</div>

<script type="text/javascript">

    /**
     * Refresh New Mail Message Count (Badge)
     */
    reloadMessageCountInterval = 60000;
    setInterval(function () {
        jQuery.getJSON("<?php echo Url::to(['/services/services/get-new-message-count-json']); ?>", function (json) {
            setServicesMessageCount(parseInt(json.newMessages));
        });
    }, reloadMessageCountInterval);

    setServicesMessageCount(<?php echo $newMailMessageCount; ?>);


    /**
     * Sets current message count
     */
    function setServicesMessageCount(count) {
        // show or hide the badge for new messages
        if (count == 0) {
            $('#badge-messages').css('display', 'none');
        } else {
            $('#badge-messages').empty();
            $('#badge-messages').append(count);
            $('#badge-messages').fadeIn('fast');
        }
    }



    // open the messages menu
    $('#icon-messages').click(function () {

        // remove all <li> entries from dropdown
        $('#dropdown-messages').find('li').remove();
        $('#dropdown-messages').find('ul').remove();

        // append title and loader to dropdown
        $('#dropdown-messages').append('<li class="dropdown-header"><div class="arrow"></div><?php echo Yii::t('MailModule.widgets_views_mailNotification', 'Messages'); ?> <?php echo Html::a(Yii::t('MailModule.widgets_views_mailNotification', 'New message'), Url::to(['/mail/mail/create', 'ajax' => 1]), array('class' => 'btn btn-info btn-xs', 'id' => 'create-message-button', 'data-target' => '#globalModal')); ?></li> <ul class="media-list"><li id="loader_messages"><div class="loader"></div></li></ul><li><div class="dropdown-footer"><a class="btn btn-default col-md-12" href="<?php echo Url::to(['/mail/mail/index']); ?>"><?php echo Yii::t('MailModule.widgets_views_mailNotification', 'Show all messages'); ?></a></div></li>');

        // load newest notifications
        $.ajax({
            'type': 'GET',
            'url': '<?php echo Url::to(['/services/services/notification-list']); ?>',
            'cache': false,
            'data': jQuery(this).parents("form").serialize(),
            'success': function (html) {
                jQuery("#loader_messages").replaceWith(html)
            }});

    })
</script>

