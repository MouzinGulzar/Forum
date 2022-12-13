<?php
include '_dbconnect.php';

function execute($query)
{
    global $conn;
    return mysqli_query($conn, $query);
}

function get_data($query, $data)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row[$data];
}

function xss($string)
{
    $string = str_replace("<", "&lt;", $string);
    $string = str_replace(">", "&gt;", $string);
    $string = str_replace("'", "\'", $string);

    return $string;
}

function time_elapsed($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'y',
        'm' => 'M',
        'w' => 'w',
        'd' => 'd',
        'h' => 'h',
        'i' => 'm',
        's' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function profile($name) {
    $fullname = explode(" ",$name);
    $first = $fullname[0];
    $last = $fullname[1];
    $profile_image = $first[0] . $last[0];
    return $profile_image;
}

function tostr($message, $info) {
    echo '<button class="btn btn-primary" id="toaster">Toaster
        <script>
            $(document).ready(function () {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                // toastr.'.$info.'("'.$message.'");
                // toastr.options.positionClass = "toast-bottom-center"
                $(\'#toaster\').click(function () {
                    toastr.options.progressBar = true;
                    toastr.error(\'Click Button\');
                });
            });
        </script>
    </button>';
}

