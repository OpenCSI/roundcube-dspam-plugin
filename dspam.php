<?php

/**
 * DSpam Plugin, display dspam preferences in iframe
 *
 * @author Bruno Bonfils
 * @author Aleksander 'A.L.E.C' Machniak
 * @license GNU GPLv3+
 *
 * Configuration (see config.inc.php.dist)
 * 
 **/

class dspam extends rcube_plugin
{
    // all task excluding 'login' and 'logout'
    public $task = '?(?!login|logout).*';
    // we've got no ajax handlers
    public $noajax = true;
    // skip frames
    // public $noframe = true;

    function init()
    {
        $rcmail = rcmail::get_instance();

        $this->add_texts('localization/', false);

        // register task
        $this->register_task('dspam');

        // register actions
        $this->register_action('index', array($this, 'action'));

        // add taskbar button
        $this->add_button(array(
            'command'    => 'dspam',
            'class'      => 'button-help',
            'classsel'   => 'button-help button-selected',
            'innerclass' => 'button-inner',
            'label'      => 'dspam.dspam',
        ), 'taskbar');

        $skin = $rcmail->config->get('skin');
        if (!file_exists($this->home."/skins/$skin/help.css"))
            $skin = 'default';

        // add style for taskbar button (must be here) and Help UI    
        $this->include_stylesheet("skins/$skin/help.css");
    }

    function action()
    {
        $rcmail = rcmail::get_instance();

        $this->load_config();

        // register UI objects
        $rcmail->output->add_handlers(array(
            'helpcontent' => array($this, 'content'),
        ));

        $rcmail->output->set_pagetitle($this->gettext('dspam'));

        $rcmail->output->send('dspam.help');
    }

    function content($attrib)
    {
        $rcmail = rcmail::get_instance();

        if ($src = $rcmail->config->get('dspam_url'))
            $attrib['src'] = $src;

        if (empty($attrib['id']))
            $attrib['id'] = 'rcmailhelpcontent';

        $attrib['name'] = $attrib['id'];

        return html::tag('iframe', $attrib, '', array(
            'id', 'class', 'style', 'src', 'width', 'height', 'frameborder'));
    }

}
