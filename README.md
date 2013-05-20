# Installation

    cd $ROUNDCUBE_HOME/plugins
    git clone https://github.com/OpenCSI/roundcube-dspam-plugin dspam

# Configuration

Ensure to load the plugins, and configure DSPAM URL:

## main.inc.php

    $rcmail_config['plugins'] = array('dspam', '..');
    $rcmail_config['dspam_url'] = 'https://mail.opencsi.com/dspam/';
    
