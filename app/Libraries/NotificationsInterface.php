<?php

namespace App\Libraries;

interface NotificationsInterface {
    /**
     * Send function needs to be present in a notification
     *
     * @return mixed
     */
    public function send();
}
