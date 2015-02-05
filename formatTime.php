<?php

function formatTime($time) {
    $seconds = time() - $time;

    if ($seconds  > 59) {
        $mins = intval($seconds / 60);

        if ($mins > 1) {

            if ($mins  > 59) {
                $hours = intval($mins / 60);

                if ($hours > 1) {


                    if ($hours > 24) {
                        $days = intval($hours / 24);

                        if ($days > 1) {

                            if ($days >= 7 ) {

                                if ($days > 7 ) {

                                    return date('F j, Y', $time);

                                } else {

                                    return "1 week ago";
                                }
                            } else {

                                return $days . " days ago";
                            }
                        } else {

                            return $days . " day ago";
                        }
                    }

                    return $hours . " hours ago";

                } else {

                    return $hours . " hour ago";
                }

            }

            return $mins . " mins ago";

        } else {

            return $mins . " min ago";

        }

    } else {

        return $seconds . " seconds ago";

    }

}

?>
